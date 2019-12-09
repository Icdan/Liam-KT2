<?php
session_start();

include "db/db_connection.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' && password = '$password'");

    if ($loginQuery) {
        $loginResult = mysqli_num_rows($loginQuery);
        if ($loginResult == 1) {
            $row = mysqli_fetch_assoc($loginQuery);
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
        } elseif ($_POST) {
            echo "Please enter a valid username or password";
        }
    } else {
        echo "bah";
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
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="Your e-mail" maxlength="75" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Your password" maxlength="25" required>
                </div>
                <input type="submit" name="login" value="Log in" class="btn btn-primary">
            </form>
            <p>Don't have an account? Sign up <a href="register.php">here!</a></p>
        </div>
    </div>
    <?php
    include "includes/footer.php"
    ?>
</body>
</html>
