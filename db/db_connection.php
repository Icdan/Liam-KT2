<?php

// Database server
$server = "localhost";
// Database gebruiker
$user = "deb7255_liam";
// Wachtwoord voor gebruiker
$password = "luxshot";
// Database selectie
$db = "deb7255_liam";

// Defineer de variabel die we later gebruiken voor queries om contact te leggen met de database
$conn = mysqli_connect($server, $user, $password, $db);

// Zodat we weten als de connectie niet goed is
if (!$conn) {
    die("Er ging iets mis met de connectie met de database");
}