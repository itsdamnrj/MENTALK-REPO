<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "mentalk_db";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
{
    die("Failed to Connect!");
}
?>