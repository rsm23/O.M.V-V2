<?php

require_once("config.inc.php");
require_once("comments.php");


function omv_encode($text) {
	return str_replace(' ', '_', $text);
}

function omv_decode($encoded_text) {
	return str_replace('_', ' ', $encoded_text);
}

function omv_get_mangas() {
	$mangas = array();

	$dirname = "mangas/";
	$dir = @opendir($dirname);
	if ($dir) {
		while (($file = @readdir($dir)) !== false) {
			if (is_dir($dirname . $file . '/') && ($file != ".") && ($file != "..")) {
				$mangas[] = $file;
			}
		}
		@closedir($dir);
	}

	sort($mangas);

	return $mangas;
}

function omv_get_chapters($manga) {
	global $omv_chapters_sorting;
	$chapters = array();
	$chapters_id = array();

	$dirname = "mangas/$manga/";
	$dir = @opendir($dirname);
	if ($dir) {

		while (($file = @readdir($dir)) !== false) {
			if (is_dir($dirname . $file . '/') && ($file != ".") && ($file != "..")) {
				$chapter = array();
				$chapter["folder"] = $file;
				$pos = strpos($file, '-');
				if ($pos === false) {
					$chapter["number"] = $file;
				} else {
					$chapter["number"] = trim(substr($file, 0, $pos - 1));
					$chapter["title"] = trim(substr($file, $pos + 1));
				}

				$chapters_id[] = $chapter["number"];

				$chapters[] = $chapter;
			}
		}
		@closedir($dir);
	}

	array_multisort($chapters_id, $omv_chapters_sorting, $chapters);

	return $chapters;
}

function omv_get_chapter_index($chapters, $chapter_number) {
	$i = 0;
	while (($i < count($chapters)) && ($chapters[$i]["number"] != $chapter_number)) $i++;

	return ($i < count($chapters)) ? $i : -1;
}

function omv_get_pages($manga, $chapter, $commentPage) {
	global $omv_img_types;
	$pages = array();

	$dirname = "mangas/$manga/$chapter/";
	$dir = @opendir($dirname);
	if ($dir) {
		while (($file = @readdir($dir)) !== false) {
			if (!is_dir($dirname . $file . '/')) {
				$file_extension = strtolower(substr($file, strrpos($file, ".") + 1));
				if (in_array($file_extension, $omv_img_types)) {
					$pages[] = $file;
				}
			}
		}
		@closedir($dir);
	}

	sort($pages);

	$pages[] = $commentPage;

	return $pages;
}

function omv_get_previous_page($manga_e, $chapter_number_e, $current_page, $previous_chapter) {
	if ($current_page > 1) {
		return $manga_e . '/' . $chapter_number_e . '/' . ($current_page - 1);
	} else if ($previous_chapter) {
		$pages = omv_get_pages(omv_decode($manga_e), $previous_chapter["folder"]);
		return $manga_e . '/' . omv_encode($previous_chapter["number"]) . '/' . count($pages);
	} else {
		return null;
	}
}

function omv_get_next_page($manga_e, $chapter_number_e, $current_page, $nb_pages, $next_chapter) {
	if ($current_page < $nb_pages) {
		return $manga_e . '/' . $chapter_number_e . '/' . ($current_page + 1);
	} else if ($next_chapter) {
		return $manga_e . '/' . omv_encode($next_chapter["number"]);
	} else {
		return null;
	}
}

function omv_get_image_size($img) {
	global $omv_img_resize, $omv_preferred_width;
	$size = array();

	$imginfo = getimagesize($img);
	$size["width"] = intval($imginfo[0]);
	$size["height"] = intval($imginfo[1]);

	if ($omv_img_resize) {
		if ($size["width"] > $omv_preferred_width) {
			$size["height"] = intval($size["height"] * ($omv_preferred_width / $size["width"]));
			$size["width"] = $omv_preferred_width;
		}
	}

	return $size;
}

?>
