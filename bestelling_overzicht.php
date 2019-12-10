<?php
//Start the session to work with PHP sessions
session_start();
//Connect to database
include "db/db_connection.php";
//If user isn't logged in they'll be redirected to the log-in page.
if (!$_SESSION['loggedin']) {
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS files -->
    <?php
    include "includes/header.php";
    ?>
    <title>Bestel overzicht</title>
</head>
<body>
<?php
include "includes/navbar.php";
?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <?php
            $id = $_POST['id_reservering'];
            $bestellingQuery = mysqli_query($conn, "SELECT bestelling_per_reservering.aantal AS aantal, menu_item.naam AS itemNaam, TRUNCATE(menu_item.prijs / 100, 2) AS prijs, IF(bestelling_per_reservering.ontvangen, 'Ja', 'Nee') AS ontvangen 
FROM `bestelling_per_reservering` 
INNER JOIN menu_item ON menu_item.id_item = bestelling_per_reservering.menu_item_id_item 
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen 
INNER JOIN reservering ON reservering.id_reservering = bestelling_per_reservering.reservering_id_reservering 
WHERE reservering_id_reservering = '$id'");

            if ($bestellingQuery) {
                $bestelAmount = mysqli_num_rows($bestellingQuery);
                if ($bestelAmount > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Item item</th><th>Aantal</th><th>Prijs per item</th><th>Bestelling ontvangen?</th>";
                    echo "</tr>";
                    for ($count = 1; $count <= $bestelAmount; $count++) {
                        $row = mysqli_fetch_assoc($bestellingQuery);
                        echo "<tr>";
                        echo "<td>" . $row['itemNaam'] . "</td><td>" . $row['aantal'] . "</td><td>€" . $row['prijs'] . "</td><td>" . $row['ontvangen'] . "</td></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Sorry, er zijn nog geen bestellingen geplaatst</p>";
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Javascript files -->
<?php
include "includes/footer.php";
?>
</body>
</html>