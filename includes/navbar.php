<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Excellent Taste</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reserveringen-overzicht.php">Reserveringen overzicht</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Reservering maken</a>
            </li>
            <?php
            if ($_SESSION['voornaam'] == 'bar') {
                echo "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Bar overzicht</a>
                       </li>";
                } elseif ($_SESSION['voornaam'] == 'keuken') {
                echo "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Keuken overzicht</a>
                       </li>";
            }
            ?>
        </ul>
    </div>
    <div class="nav navbar-nav navbar-right">
        <a class="btn btn-primary" href="logout.php">Log out<span class="sr-only">(current)</span></a>
    </div>
</nav>