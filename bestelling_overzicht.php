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
            $_SESSION['id_reservering'] = $_POST['id_reservering'];

            $reserveringNaamQuery = mysqli_query($conn, "SELECT naam from reservering WHERE id_reservering = '$id'");
            $reserveringNaamRow = mysqli_fetch_assoc($reserveringNaamQuery);

            echo "<h3>Reservering: " . $reserveringNaamRow['naam'] . "</h3>";

            if ($_SESSION['gebruikersnaam'] == "keuken") {
                $bestellingQuery = mysqli_query($conn, "SELECT bestelling_per_reservering.aantal AS aantal, menu_item.naam AS itemNaam, TRUNCATE(menu_item.prijs / 100, 2) AS prijs 
FROM `bestelling_per_reservering` 
INNER JOIN menu_item ON menu_item.id_item = bestelling_per_reservering.menu_item_id_item 
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen 
INNER JOIN reservering ON reservering.id_reservering = bestelling_per_reservering.reservering_id_reservering 
WHERE reservering_id_reservering = '$id' AND (menu_categorieen.id_menu_categorieen = '5' OR menu_categorieen.id_menu_categorieen = '6')");
            } else {
                $bestellingQuery = mysqli_query($conn, "SELECT bestelling_per_reservering.aantal AS aantal, menu_item.naam AS itemNaam, TRUNCATE(menu_item.prijs / 100, 2) AS prijs 
FROM `bestelling_per_reservering` 
INNER JOIN menu_item ON menu_item.id_item = bestelling_per_reservering.menu_item_id_item 
INNER JOIN menu_categorieen ON menu_categorieen.id_menu_categorieen = menu_item.menu_categorieen_id_menu_categorieen 
INNER JOIN reservering ON reservering.id_reservering = bestelling_per_reservering.reservering_id_reservering 
WHERE reservering_id_reservering = '$id'");
            }

            if ($bestellingQuery) {
                $bestelAmount = mysqli_num_rows($bestellingQuery);
                if ($bestelAmount > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Gerecht</th><th>Aantal</th><th>Prijs per item</th>";
                    echo "</tr>";
                    for ($count = 1; $count <= $bestelAmount; $count++) {
                        $bestellingRow = mysqli_fetch_assoc($bestellingQuery);
                        echo "<tr>";
                        echo "<td>" . $bestellingRow['itemNaam'] . "</td><td>" . $bestellingRow['aantal'] . "</td><td>€" . $bestellingRow['prijs'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Sorry, er zijn nog geen bestellingen geplaatst</p>";
                }
            }
            if ($_SESSION['gebruikersnaam'] !== "keuken" && $_SESSION['gebruikersnaam'] !== "bar") {
                echo "
            <hr>
        </div>
    </div>
    <div class=\"row\">
        <div class=\"col-12 text-center\">
            <h3>Bestelling plaatsen</h3>
        </div>
    </div>
    <div class=\"row\">
        <div class=\"col-3\">
            <button type=\"button\" onclick=\"buttonWarmeDranken()\">Warme dranken</button>
            <br>
            <button type=\"button\" onclick=\"buttonBieren()\">Bieren</button>
            <br>
            <button type=\"button\" onclick=\"buttonHuiswijnen()\">Huiswijnen</button>
            <br>
            <button type=\"button\" onclick=\"buttonFrisdranken()\">Frisdranken</button>
            <br>
            <button type=\"button\" onclick=\"buttonWarmeHapjes()\">Warme hapjes</button>
            <br>
            <button type=\"button\" onclick=\"buttonKoudeHapjes()\">Koude hapjes</button>
            <br>
        </div>
        <div class=\"col-9 text-center\" id=\"ajax-items-container\">
        </div>
    </div>
    <hr>
    <div class=\"row\">
        <div class=\"col-12 text-center\" id=\"ajax-bon-container\">
            <form method=\"post\" action=\"bon.php\">
                <label>Hoe is er betaald?</label><br>
                <select name=\"betaalOptie\">
                    <option value=\"pin\">PIN / Creditcard</option>
                    <option value=\"contant\">Contant</option>
                </select>
                <br><br>
                <label>Hoeveel is er betaald?</label><br>
                <input type=\"number\" name=\"hoeveelheidBetaald\" step=\"any\">
                <br>
                <input type=\"submit\" name=\"submit\" value=\"Print bon\">

        </div>
    </div>";
            }
    ?>
</div>
<!-- Javascript files -->
<script>
    bonDoc = document.getElementById("ajax-bon-container")
    bonDoc.innerHTML

    var xhttp = new XMLHttpRequest();

    function ajaxCallMenuItems() {
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajax-items-container").innerHTML = this.responseText;
            }
        };
    }

    function buttonWarmeDranken() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/warmedranken.php", true);
        xhttp.send();
    }

    function buttonBieren() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/bieren.php", true);
        xhttp.send();
    }

    function buttonHuiswijnen() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/huiswijnen.php", true);
        xhttp.send();
    }

    function buttonFrisdranken() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/frisdranken.php", true);
        xhttp.send();
    }

    function buttonWarmeHapjes() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/warmehapjes.php", true);
        xhttp.send();
    }

    function buttonKoudeHapjes() {
        ajaxCallMenuItems();
        xhttp.open("GET", "ajax/koudehapjes.php", true);
        xhttp.send();
    }

    function printBon() {
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajax-bon-container").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/bon.php", true);
        xhttp.send();
    }
</script>
<?php
include "includes/footer.php";
?>
</body>
</html>