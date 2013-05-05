Twitter API Mirror
------------------

PHP service to collect your twitter feeds (Twitter API 1.1) and distribute them to client side scripts by JSONP. It uses [TwitterOAuth](https://github.com/abraham/twitteroauth) to connect to Twitter. It caches all services within a user defined interval.

## Setup
1. Add your Twitter API details to config.php (see config_sample.php).
2. Add your service names and their Twitter-API-URL to config.php (see config_sample.php).
3. Choose a proper time limit for your cached files.
4. Check index.php.

## How to use it
Simply call the service-url with a callback function (? if using jQuery's getJSON).

Example:

```html
<div id="tweets">Rotate these letters.</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        var twitterapimirror = "http://YOUR_SERVICE_LOCATION.COM/twittermirror/?s=YOUR_SERVICE_NAME&callback=?";

        $.getJSON(twitterapimirror, function(json) {
            $("#tweets").html("");
            for (var key in json) {
                text = json[key].text;
                text = text.replace(exp,"<a href='$1'>$1</a>");
                date = new Date(json[key].created_at);
                $("#tweets").append(""+date.getDate()+"/"+date.getMonth()+" "+date.getFullYear()+"<br />"+text+"<br /><br />");
            }
        });
    });
</script>
```
A testfile (test.php) is also included.


## In Use:
- [Barnt & Arnst Twitter API Mirror Services](http://barntarnst.com/twittermirror)


