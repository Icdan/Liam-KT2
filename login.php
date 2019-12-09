<?php
session_start();

include "db/db_connection.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginQuery = mysqli_query($conn, "SELECT * FROM `medewerker` WHERE gebruikersnaam = '$username' && wachtwoord = '$password'");

    if ($loginQuery) {
        $loginResult = mysqli_num_rows($loginQuery);
        if ($loginResult == 1) {
            $row = mysqli_fetch_assoc($loginQuery);
            $_SESSION['voornaam'] = $row['voornaam'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
        } elseif ($_POST) {
            echo "Please enter a valid username or password";
        }
    } else {
        echo "This is a testing error so I know where it goes wrong";
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <?php
    include "includes/header.php"
    ?>
    <title>Log-in page</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post">
                <div class="form-group">
                    <label>Gebruikersnaam</label>
                    <input type="text" name="username" placeholder="Uw gebruikersnaam" maxlength="75" required>
                </div>
                <div class="form-group">
                    <label>Wachtwoord</label>
                    <input type="password" name="password" placeholder="Uw wachtwoord" maxlength="25" required>
                </div>
                <input type="submit" name="login" value="Log in" class="btn btn-primary">
            </form>
        </div>
    </div>
    <?php
    include "includes/footer.php"
    ?>
</body>
</html>
