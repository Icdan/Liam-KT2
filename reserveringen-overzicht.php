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
    <title>Reserveringen overzicht</title>
</head>
<body>
<?php
include "includes/navbar.php";
?>
<div class="container">
    <div class="row">
        <div class="col text-center">
            <table>
                <tr>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Tafel</th>
                    <th>Naam</th>
                    <th>Telefoon</th>
                    <th>Aantal personen</th>
                    <th>Commentaar</th>
                    <th>Allergieen</th>
                    <th>Reservering gebruikt</th>
                </tr>
                <?php
                $reserveringQuery = mysqli_query($conn, "SELECT *, IF(reservering_gebruikt, 'Ja', 'Nee') AS gebruikt from reservering ");

                if ($reserveringQuery) {
                    $reserveringAmount = mysqli_num_rows($reserveringQuery);
                    for ($count = 1; $count <= $reserveringAmount; $count++) {
                        $row = mysqli_fetch_assoc($reserveringQuery);
                        echo "<tr>";
                        echo "<td>" . $row['datum'] . "</td><td>" . $row['tijd'] . "</td><td>" . $row['tafel'] . "</td><td>" . $row['naam'] . "</td><td>" . $row['telefoon'] . "</td><td>" . $row['aantal_personen'] . "</td><td>" . $row['commentaar'] . "</td><td>" . $row['allergieen'] . "</td><td>" . $row['gebruikt'] . "</td>";
                        echo "<td><form method='post' action='bestelling_overzicht.php'><input type='hidden' value=" . $row['id_reservering'] . " name='id_reservering'><input type='submit' value='Bestellingen'></form></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
<!-- Javascript files -->
<?php
include "includes/footer.php";
?>
</body>
</html>