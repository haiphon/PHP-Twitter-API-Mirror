<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', 'YOUR CONSUMER KEY');
define('CONSUMER_SECRET', 'YOUR CONSUMER SECRET');
define('OAUTH_CALLBACK', 'CALLBACK URL');

define('ACCESS_TOKEN', 'YOUR APP ACCESS TOKEN');
define('ACCESS_TOKEN_SECRET', 'YOUR APP ACCESS TOKEN SECRET');

/* Define services */
$services = array();
$services['barntarnst'] = 'statuses/user_timeline.json?screen_name=barntarnst&include_rts=true&count=5';

/* Define cache update time in seconds */
$cachetime = 3600*0.5;

/* Define some strings for information page */
$title = "Bärnt & Ärnst Twitter API Mirror";

