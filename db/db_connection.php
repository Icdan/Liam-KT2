<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "excellent_taste";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Something went wrong with connecting to the database");
}