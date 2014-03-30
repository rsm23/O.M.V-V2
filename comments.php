<?php
$commentPage = "<hr />";
$commentPage .="<div id='disqus_thread' style='width:800px;padding:0 20px;'></div>";
$commentPage .="<script type='text/javascript'>";
$commentPage .="var disqus_shortname = '".$disqus_shortname."';";
$commentPage .="(function() {";
$commentPage .="var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;";
$commentPage .="dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';";
$commentPage .="(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);";
$commentPage .="})();";
$commentPage .="</script>";
$commentPage .="<noscript>Please enable JavaScript to view the <a href='http://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript>";
$commentPage .="<a href='http://disqus.com' class='dsq-brlink'>comments powered by <span class='logo-disqus'>Disqus</span></a>";
$commentPage .= "";
?>