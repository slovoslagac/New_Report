<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 25.11.2016
 * Time: 14:00
 */


    $html=file_get_contents('https://meridianbet.rs/home/leagues/80');
    echo $html;
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>on demo</title>
    <style>
        p {
            color: red;
        }
        span {
            color: blue;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<button id='click_me'>Click me</button>
<span style="display:none;"></span>
<script>

    $( "#click_me" ).click(function () {
        $.get("/get-website.php", function(data) {
            var json = {
                html: JSON.stringify(data),
                delay: 1
            };
            alert(json.html);
        });
    });
</script>
</body>
</html>


