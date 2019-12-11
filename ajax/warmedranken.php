<?php
//Start the session to work with PHP sessions
session_start();
//Connect to database;
include "../db/db_connection.php";

$id = $_SESSION['id_reservering'];

$categoryItemQuery = "SELECT menu_item.naam AS itemNaam, menu_item.id_item, menu_categorieen.id_menu_categorieen AS categorie_id, menu_item.prijs AS prijs
FROM menu_item
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen
WHERE menu_categorieen.id_menu_categorieen = 1";
$categoryResult = mysqli_query($conn, $categoryItemQuery);

$countForms = 0;

echo "<table>";
if (mysqli_num_rows($categoryResult) > 0) {
    while ($categoryItemRow = mysqli_fetch_assoc($categoryResult)) {
        $countForms++;
        echo "<tr>";
        echo "<td><form name='addToOrderForm' method='post' action='reserveringen-overzicht.php'>
<input type='submit' name='opslaanInBestelling' value='" . $categoryItemRow['itemNaam'] . "'>
<input type='hidden' value='" . $categoryItemRow['id_item'] . "' name='reservationOrderItemid'>
<input type='hidden' value='" . $categoryItemRow['categorie_id'] . "' name='reservationOrderCategoryid'>
<input type='input' name='reservationOrderAmount'>
<input type='hidden' value='$id' name='reservationOrderid'>
</form>
</td>
<td>€
<form method='post' action='reserveringen-overzicht.php' id='editDrinksForm" . $countForms . "'></form>
<input type='numbers' id='menuItemPrijs' name='prijsDieVeranderdWord' value='". $categoryItemRow['prijs'] . "' form='editDrinksForm" . $countForms . "'/>
</td>
<td>
<input type='hidden' name='prijsWijzigingDatabase' value='" . $categoryItemRow['id_item'] ."' form='editDrinksForm" . $countForms . "'/>
<input type='submit' value='Prijswijziging opslaan' form='editDrinksForm" . $countForms . "' name='opslaanPrijsWijziging'/>
</td>";
        echo "</tr>";
    }
}
echo "<table>";