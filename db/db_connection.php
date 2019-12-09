<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "test";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Something went wrong with connecting to the database");
}