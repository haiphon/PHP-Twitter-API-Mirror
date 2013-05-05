<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<title>Twitter Mirror Test</title>
	<meta name="description" content="Twitter Mirror Test">
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
		<div id="tweets">
		</div>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() {

	$(".title").lettertwist(12);

    //Fetch tweets.
    var twitterapimirror = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/twittermirror/?s=barntarnst&count=5&callback=?";
    //var twitterapimirror = "http://barntarnst.com/twittermirror/?s=barntarnst&count=5&callback=?";
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    var text = "";
    var date = "";

    $.getJSON(twitterapimirror, function(json) {
        $("#tweets").html("");
        for (var key in json) {
            text = json[key].text;
            text = text.replace(exp,"<a href='$1'>$1</a>");
            date = new Date(json[key].created_at);
            $("#tweets").append("<span class='twist small'>"+date.getDate()+"/"+date.getMonth()+" "+date.getFullYear()+"</span><br />"+text+"<br /><br />");
        }
        $(".twist").lettertwist(12);
    });
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