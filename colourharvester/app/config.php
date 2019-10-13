<?php
ob_start();
if (!isset($_SESSION)) {
	session_start();
}

$current_page_uri = $_SERVER['REQUEST_URI'];
$part_url = explode("/", $current_page_uri);
$page_name = end($part_url);
$_SESSION["file_name"] = "";
$email_id = "allan@odhiambo.me.ke";
ob_end_flush();
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-29056778-4', 'auto');
  ga('send', 'pageview');

</script>