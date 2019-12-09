<?php

session_start();
session_unset();
session_destroy();

echo "<p align='center' style='margin-top:20%'>You have been logged out</p>";

header("Refresh:1; url=index.php");