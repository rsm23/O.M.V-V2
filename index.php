<?php

require_once("config.inc.php");
require_once("functions.inc.php");
require_once("comments.php");


$theme = $omv_theme;

$manga = null;
$manga_escaped = null;

$chapter = null;
$chapter_number = null;
$chapter_number_escaped = null;
$previous_chapter = null;
$next_chapter = null;

$page = null;

$description = "";
$title = $omv_title;

$mangas = omv_get_mangas();
if (isset($_GET["manga"])) {
	$manga_title = omv_decode($_GET["manga"]);
	if (in_array($manga_title, $mangas)) {
		$manga = $manga_title;
		$manga_escaped = $_GET["manga"];
	}
}

if ($manga) {
	$description = "Read " . $manga . " Manga Online";
	$title .= " - " . $manga;

	$chapters = omv_get_chapters($manga);
	if (isset($_GET["chapter"])) {
		$chapter_number = omv_decode($_GET["chapter"]);
		$index = omv_get_chapter_index($chapters, $chapter_number);
		if ($index != -1) {
			$chapter = $chapters[$index];
			$chapter_number_escaped = $_GET["chapter"];
			if ($omv_chapters_sorting == SORT_ASC) {
				if ($index > 0) {
					$previous_chapter = $chapters[$index - 1];
				}
				if ($index < (count($chapters) -  1)) {
					$next_chapter = $chapters[$index + 1];
				}
			} else {
				if ($index < (count($chapters) -  1)) {
					$previous_chapter = $chapters[$index + 1];
				}
				if ($index > 0) {
					$next_chapter = $chapters[$index - 1];
				}
			}
		}
	} else {
		$chapter = $chapters[0];
		$chapter_number = $chapters[0]["number"];
		$chapter_number_escaped = omv_encode($chapter_number);
		
		if (count($chapters) > 1) {
			if ($omv_chapters_sorting == SORT_ASC) {
				$next_chapter = $chapters[1];
			} else {
				$previous_chapter = $chapters[1];
			}
		}
	}

	if ($chapter) {
		global $commentPage;
		$pages = omv_get_pages($manga, $chapter["folder"], $commentPage);
		if (isset($_GET["page"])) {
			$_page = intval($_GET["page"]);
			if (($_page >= 1) && ($_page <= count($pages))) {
				$page = $_page;
			}
		} else if (count($pages) > 0) {
			$page = 1;
		}

		$title .= " - Chapter " . $chapter_number;

		if ($page) {
			$title .= " - Page " . $page;
		}
	}
}
$msg = "<p class='btn btn-danger' style='margin:10px 0'>The last page of the chapter is the comments page</p>";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<base href="<?php echo $omv_base_url ?>" />
<meta name="Keywords" content="<?php echo str_replace(' ', ',', $description) ?>" />
<meta name="Description" content="<?php echo $description ?>" />
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv="Content-Language" content="en" />
<title><?php echo $title ?></title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/superhero/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo $omv_base_url ?>themes/<?php echo $theme ?>/omv.css" type="text/css" media="screen" />

<script type="text/javascript">
function change_manga(manga) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga;
	}
}

function change_chapter(manga, chapter) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga + "/" + chapter;
	}
}

function change_page(manga, chapter, page) {
	if (manga != 0) {
		document.location = "<?php echo $omv_base_url ?>" + manga + "/" + chapter + "/" + page;
	}
}
</script>

</head>

<body>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $omv_base_url ?>">Free O.M.V</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo $omv_base_url ?>">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Popular Mangas <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Naruto</a></li>
            <li><a href="#">Bleach</a></li>
            <li><a href="#">One Piece</a></li>
            <li><a href="#">Toriko</a></li>
            <li><a href="#">Beelzebub</a></li>
            <li><a href="#">Fairy Tail</a></li>
            <li><a href="#">Kingdom</a></li>
          </ul>
        </li>
        <li style="padding-top:10px;">
        	<!-- Social -->
        	<!-- Place this tag where you want the +1 button to render. -->
        	<div class="g-plusone" data-size="medium"></div>

        	<!-- Place this tag after the last +1 button tag. -->
        	<script type="text/javascript">
        	  window.___gcfg = {lang: 'pt-BR'};

        	  (function() {
        	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        	    po.src = 'https://apis.google.com/js/plusone.js';
        	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        	  })();
        	</script>
        	<a href="https://twitter.com/share" class="twitter-share-button" data-via="Akianimes" data-lang="pt" data-hashtags="Akianimes">Tweetar</a>
        	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

        	<!-- inicio facebook -->
        	<script type="text/javascript"><!--
        	urlb=window.location.href;document.write("<iframe src='//www.facebook.com/plugins/like.php?href="+urlb+"&amp;layout=button_count&amp;action=like&amp;font=arial' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:80px; height:20px'></iframe>"); //--></script>
        	<!-- fim facebook -->
        	<!-- Fim Social -->
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Credits <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="http://www.rahmani.site">Rahmani Saif</a></li>
            <li><a href="http://bootswatch.com/superhero/">Using Super Hero - Bootswatch</a></li>
            <li><a href="mailto:saif@rahmani.com">Contact</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div id="omv" class="container">
<table>
<tr>
<td class="mid">
<table>
<tr>
<td>
<?php
$omv_pager = "";

$omv_pager .= "<div class=\"well\">\n";

$omv_pager .= "<span>Manga <select class=\"form-control\" style='margin-bottom:10px;' name=\"manga\" onchange=\"change_manga(this.value)\">";
$omv_pager .= "<option class=\"form-control\" value=\"0\">Select a manga title...</option>";
for ($i = 0; $i < count($mangas); $i++) {
	$m = $mangas[$i];
	$omv_pager .= "<option value=\"" . omv_encode($m) . "\"" . (($m == $manga) ? " selected=\"selected\"" : "") . ">" . $m . "</option>";
}
$omv_pager .= "</select></span>\n";

if ($manga) {
	if ($chapter) {
		$omv_pager .= "<span>Chapter <select class=\"form-control chapter-form\" name=\"chapter\" onchange=\"change_chapter('$manga_escaped', this.value)\">";
		for ($i = 0; $i < count($chapters); $i++) {
			$cnumber = $chapters[$i]["number"];
			$omv_pager .= "<option value=\"" . omv_encode($cnumber) . "\"" . (($cnumber == $chapter_number) ? " selected=\"selected\"" : "") . ">" . $cnumber . (isset($chapters[$i]["title"]) ? (" - " . $chapters[$i]["title"]) : "") . "</option>";
		}
		$omv_pager .= "</select></span>\n";

		if ($page) {
			$prevhtml = "";
			if ($page <= 1) {
				$prevhtml = "<img src='".$omv_base_url."themes/default/no-previous.png' alt='' />";
			} else {
				$prevhtml = "<a href=\"$manga_escaped/$chapter_number_escaped/" . ($page - 1) . "\"><img src=\"http://www.leitor.tk/themes/default/previous.png\" alt=\"Previous Page\" title=\"Previous Page\" /></a>";
			}
			$nexthtml = "";
			if ($page >= count($pages)) {
				$nexthtml = "<img src='".$omv_base_url."themes/default/no-next.png' alt=\"\" />";
			} else {
				$nexthtml = "<a href=\"$manga_escaped/$chapter_number_escaped/" . ($page + 1) . "\"><img src=\"http://www.leitor.tk/themes/default/next.png\" alt=\"Next Page\" title=\"Next Page\" /></a>";
			}

			 $omv_pager .= "<span>$prevhtml Page <select class=\"form-control page-form\" name=\"page\" onchange=\"change_page('$manga_escaped', '$chapter_number_escaped', this.value)\">";
			                        for ($p = 1; $p <= count($pages); $p++) {
			                                $omv_pager .= "<option value=\"" . $p . "\"" . (($p == $page) ? " selected=\"selected\"" : "") . ">" . ($p == count($pages) ? "Comments" : $p) . "</option>";
			                        }
			                        $omv_pager .= "</select> of " . count($pages) . " $nexthtml</span>\n";
			                }
			        }
			}

$omv_pager .= "<br /><p class='text-muted btn btn-info'>Use left and right arrows to navigate between pages</p></div>\n";

echo $omv_pager;
?>
</td>
</tr>
<tr>
<td>
<?php
if ($manga) {
	if ($chapter) {
		if ($page) {
			$img = "mangas/" . $manga . "/" . $chapter["folder"] . "/" . $pages[$page - 1];
			$imgsize = omv_get_image_size($img);
			if ($page >= count($pages)) {
				$comments = "<p class='btn btn-danger' style='margin:10px 0;'>".str_replace("mangas", "Comments of : ", $img)."</p>";
				$imghtml = $comments;

			} else {
				$imghtml = $msg."<br /><img src=\"$img\" alt=\"\" width=\"" . $imgsize["width"] . "\" height=\"" . $imgsize["height"] . "\" class=\"picture\" />";
			}			
			$prev_page_path = omv_get_previous_page($manga_escaped, $chapter_number_escaped, $page, $previous_chapter);
			$next_page_path = omv_get_next_page($manga_escaped, $chapter_number_escaped, $page, count($pages), $next_chapter);
			
			if ($next_page_path) {
				$imghtml = "<a href=\"$next_page_path\">" . $imghtml . "</a>";
			}
			echo $imghtml;
		} else {
			echo "<p class=\"text-danger\">There is no selected page!</p>";
		}
	} else {
		echo "<p class=\"text-danger\">There is no selected chapter!</p>";
	}
} else {
	echo "<p class=\"text-danger select-manga-msg\">Select a Manga to get started</p>";
}
?></td>
</tr>
<?php
if ($manga && $chapter && $page) {
?>
<tr>
<td>
<script type="text/javascript">
function omvKeyPressed(e) {
	var keyCode = 0;
	
	if (navigator.appName == "Microsoft Internet Explorer") {
		if (!e) {
			var e = window.event;
		}
		if (e.keyCode) {
			keyCode = e.keyCode;
			if ((keyCode == 37) || (keyCode == 39)) {
				window.event.keyCode = 0;
			}
		} else {
			keyCode = e.which;
		}
	} else {
		if (e.which) {
			keyCode = e.which;
		} else {
			keyCode = e.keyCode;
		}
	}
	
	switch (keyCode) {
<?php
if ($prev_page_path) {
?>
		case 37:
		window.location = "<?php echo $omv_base_url . $prev_page_path ?>";
		return false;
		
<?php
}
if ($next_page_path) {
?>
		case 39:
		window.location = "<?php echo $omv_base_url . $next_page_path ?>";
		return false;
		
<?php
}
?>
		default:
		return true;
	}
}
document.onkeydown = omvKeyPressed;
</script>
</td>
</tr>
<tr>
<td>
<?php
echo $omv_pager;
?>
</td>
</tr>
<?php
} else {
?>
<tr>
<td><br /></td>
</tr>
<?php
}
?>
</table>

</td>

</tr>
</table>

</div>
<div id="footer">
      <div class="container">
        <p class="text-info">All rights reserved to <a href="/"><?php echo $omv_title; ?></a> - &copy; 2014</p>
      </div>
    </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>
