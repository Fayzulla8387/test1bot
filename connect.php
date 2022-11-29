<?php

//mysql://b882aadfdb7fdf:b32701d8@us-cdbr-east-06.cleardb.net/heroku_0d2f6f079e14839?reconnect=true

$servername = "us-cdbr-east-06.cleardb.net";
$username = "b882aadfdb7fdf";
$password = "b32701d8";
$dbname = "heroku_0d2f6f079e14839";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


