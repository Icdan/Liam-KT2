<?php
//Start the session to work with PHP sessions
session_start();
//Connect to database;
include "../db/db_connection.php";

$id = $_SESSION['id_reservering'];

$categoryItemQuery = "SELECT menu_item.naam AS itemNaam, menu_item.id_item, menu_categorieen.id_menu_categorieen AS categorie_id
FROM menu_item
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen
WHERE menu_categorieen.id_menu_categorieen = 3";
$categoryResult = mysqli_query($conn, $categoryItemQuery);

if (mysqli_num_rows($categoryResult) > 0) {
    while ($categoryItemRow = mysqli_fetch_assoc($categoryResult)) {
        echo "<button onclick>" . $categoryItemRow['itemNaam'] . "</button><br>";
    }
}


