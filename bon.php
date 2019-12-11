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
    <title>Bon overzicht</title>
</head>
<body>
<?php
include "includes/navbar.php";
?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <?php

            $id = $_SESSION['id_reservering'];

            $reserveringNaamQuery = mysqli_query($conn, "SELECT naam from reservering WHERE id_reservering = '$id'");
            $reserveringNaamRow = mysqli_fetch_assoc($reserveringNaamQuery);

            echo "<h3>Bon: " . $reserveringNaamRow['naam'] . "</h3>";

            $bonQuery = "SELECT bestelling_per_reservering.aantal AS aantal, menu_item.naam AS itemNaam, menu_item.prijs AS prijs, reservering.tafel as tafel, reservering.tijd as tijd, DATE_FORMAT(reservering.datum, \"%d-%M-%Y\") as datum
FROM `bestelling_per_reservering` 
INNER JOIN menu_item ON menu_item.id_item = bestelling_per_reservering.menu_item_id_item 
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen 
INNER JOIN reservering ON reservering.id_reservering = bestelling_per_reservering.reservering_id_reservering 
WHERE reservering_id_reservering = '$id'";
            $bonResult = mysqli_query($conn, $bonQuery);

            $totaalPrijsQuery = "SELECT SUM(menu_item.prijs) AS totaalprijs
FROM `bestelling_per_reservering` 
INNER JOIN menu_item ON menu_item.id_item = bestelling_per_reservering.menu_item_id_item 
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen 
INNER JOIN reservering ON reservering.id_reservering = bestelling_per_reservering.reservering_id_reservering 
WHERE reservering_id_reservering = '$id'";
            $totaalPrijsResult = mysqli_query($conn, $totaalPrijsQuery);

            $bonDataResult = mysqli_query($conn, $bonQuery);
            $bonDataRow = mysqli_fetch_assoc($bonDataResult);
            echo "Tafel: " . $bonDataRow['tafel'] . "<br>";
            echo "Datum: " . $bonDataRow['datum'] . "<br>";
            echo "Tijd: " . $bonDataRow['tijd'] . "<br>";

            if ($bonQuery && $totaalPrijsQuery) {
                $bonAmount = mysqli_num_rows($bonResult);
                if ($bonAmount > 0) {
                    $bonPrijs = 0;
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Item item</th><th>Prijs per item</th><th>Aantal</th><th>Totaal</th>";
                    echo "</tr>";
                    for ($count = 1; $count <= $bonAmount; $count++) {
                        $bonRow = mysqli_fetch_assoc($bonResult);
                        $subtotaal = ($bonRow['prijs'] * $bonRow['aantal']);
                        $subtotaal = number_format((float)$subtotaal, 2);

                        echo "<tr>";
                        echo "<td>" . $bonRow['itemNaam'] . "</td><td>€" . $bonRow['prijs'] . "</td><td>" . $bonRow['aantal'] . "</td><td>€" . $subtotaal . "</td>";
                        echo "</tr>";
                        $bonPrijs = ($bonRow['prijs'] * $bonRow['aantal']) + $bonPrijs;
                        $bonPrijs = number_format((float)$bonPrijs, 2);
                    }
                    echo "<tr>";
                    echo "<td></td><td></td><td></td><td>€" . $bonPrijs . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td></td><td>Betaald</td><td></td><td>€" . number_format((float)$_POST['hoeveelheidBetaald'], 2) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td></td><td>Terug</td><td></td><td>€" . ($_POST['hoeveelheidBetaald'] - $bonPrijs) . "</td>";
                    echo "</tr>";

                    echo "</table>";
                }
            }
            echo "<input type='button' value='Print this page' onclick='printPage()' id='printButton' />";

            include "includes/footer.php";
            ?>
        </div>
    </div>
</div>
<script>
    function printPage() {
        document.getElementById("printButton").style.visibility = "hidden";
        window.print();
    }
</script>
</body>
</html>
