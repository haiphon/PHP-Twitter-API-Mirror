<?php
/**
 *
 *		Simple library to generate a 'twitter-api-1.1-mirror' 
 * 		to make client-side api calls from your apps!
 *		
 *		by Barnt & Arnst
 *
 *		TODO: 
 *			- Cache calls!
 *			- Make information page external
 *			- Count should be set in config! (Could be optional)
 *
 */

/* Supported Twitter API version */
$supportAPIv = '1.1';

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

if(isset($_GET['s'])) {
	/*
	*	JSON and JSONP (when callback=? is supplied as GET)
	*	
	*/

	if(isset($_GET['count'])) { $count = $_GET['count']; }
	else { $count = 10; }

	if(array_key_exists($_GET['s'], $services)) {

		/* Check if service is cached */
		if(file_exists('cache/'.$_GET['s'].".json") && (time() - filemtime('cache/'.$_GET['s'].".json")) < $cachetime) {
			/* Read from cache */
			$content = file_get_contents("cache/".$_GET['s'].".json");
		} else {
			$content = $connection->get($services[$_GET['s']]);
			$content = json_encode($content);
			/* Save to cache */
			$check = file_put_contents("cache/".$_GET['s'].".json", $content);
		}

		/* Json-p or just json? */
		if(isset($_GET['callback'])) {
			header('Content-Type: application/javascript');
			echo $_GET['callback']."(".$content.");";
		}
		else {
			header('Content-Type: application/json');
			echo $content;
		}
	}

} else { 
	/*
	*	Information page (shown when no service is called)	
	*
	*/
?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $title; ?>">
	<meta name="author" content="Barnt&Arnst">
	<meta name="viewport" content="width=1000">
	<style type="text/css" media="screen">
		body {
		    background-color: rgb(34, 181, 115);
		    font-size: 20px;
			color: #fff;
			font-family: 'Andale Mono', 'PT Sans', tahoma, sans-serif;
		}
		.title {
			font-size: 34px;
			color: rgb(255, 232, 139);
			text-transform: uppercase;
		}
		#content {
			margin: 10%;
			min-width: 500px;
		}
		.urls {
			font-size: 20px;
			color: rgb(255, 232, 139);
		}
		a {
			text-decoration: none;
			color: rgb(255, 232, 139);
		}
		a:hover {
			text-decoration: underline;
		}
	</style>
	<link href="http://fonts.googleapis.com/css?family=PT+Sans:regular,italic" rel="stylesheet" type="text/css" />
</head>
<style>
</style>
<body>
	<div id="content">
		<span class="title"><?php echo $title; ?></span><br /><br />

		<?php
			echo "Supports Twitter API v".$supportAPIv."<br />";
			$content = $connection->get('account/rate_limit_status');
			echo "Current API hits remaining: {$content->remaining_hits}";
			echo "<br />Cache timelimit set to ".$cachetime."s";
		?>
		<br /><br /><br /><br />Services:
		<?php 
			foreach($services as $key => $val) { ?>
				<span class="urls"><?php echo $key; ?></span><?php if(end($services) !== $val) { echo ','; } ?>
		<?php } ?><br /><br /><br />
		Sample request URL's (JSONP):<br /><br />
		<?php 
			$host = $_SERVER['HTTP_HOST'];
			foreach($services as $key => $val) { ?>
				<a href="http://<?php echo $host; ?>/twittermirror/?s=<?php echo $key;?>&count=<?php echo rand(1,20);?>&callback=?"><span class="urls"><?php echo $host; ?>/twittermirror/?s=<?php echo $key;?>&count=<?php echo rand(1,20);?>&callback=?</span></a><br /><br />
		<?php } ?><br /><br />
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$(".title").lettertwist(12);
});
/**
*
*   Lettertwist - jQuery plugin to rotate letters in a text.
*   by Barnt & Arnst 
*
*   Simply -  $(element).lettertwist(20) 
*   to rotate each letter of that element with 20 degrees.
*   
*   Defualt degrees: 15
*
**/ 
(function($) {
  $.fn.lettertwist = function(degrees, title, all) {
    if(typeof degrees === 'undefined') { degrees = 15; }
    return this.each(function() {
        title = ($(this).text()).split('');
        all = '';
        for(var i in title) {
            if(title[i] === ' ') { title[i] = '&nbsp;'; }
            all += "<div style='display: inline-block; padding-right: 5px; -webkit-transform: rotate("+degrees+"deg); -moz-transform: rotate("+degrees+"deg); -o-transform: rotate("+degrees+"deg);'>"+title[i]+"</div>";
        }
        $(this).html(all);
    });
  };
})(jQuery);
</script>
</body>
</html>

<?php
}
?>
