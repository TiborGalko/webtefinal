<?php
include_once "../db/usersdb.php";
include_once "../db/vykonydb.php";

session_start();

$userinfo = getAllUserInfoFromUsers();

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Aplikácia - výkony</title>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

    <!-- news script -->
    <script src="../news/news-script.js"></script>
    <script src="../libs/jquery.redirect-master/jquery.redirect.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpnArBmSGhkTmYTQRXiDZMi9h6xj1LwHA"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <script src="vykony.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header class="jumbotron">
    <h1>Aplikácia - výkony</h1>
</header>
<nav>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="app_admin.php">Aplikácia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="vykony_admin.php">Výkony</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="newsletter_admin.php">Newsletter</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="nastavenia.php">Nastavenia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="signout.php">Odhlásiť sa</a>
        </li>
    </ul>
</nav>
<div class="container">
    <h2>Uživatelia</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Email</th>
            <th>Meno</th>
            <th>Priezvisko</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($userinfo as $row) {
            if($row['role'] === 'user') {
                echo "<tr onclick='getUserVykony(" . $row['id'] . ")'>" .
                    "<td>" . $row['email'] . "</td>" .
                    "<td>" . $row['name'] . "</td>" .
                    "<td>" . $row['surname'] . "</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <input type="hidden" id="tabOrder" value="asc">
    <input type="hidden" id="tabColumn" value="id">
    <input type="hidden" id="user_id" value="">
    <table id="tabVykonov" class="table">
        <thead>
        <tr>
            <th onclick="sort('kilometre')">Počet kilometrov</th>
            <th onclick="sort('den')">Deň</th>
            <th onclick="sort('cas_start')">Začiatok tréningu</th>
            <th onclick="sort('cas_finish')">Koniec tréningu</th>
            <th onclick="sort('latlng_start')">GPS štart</th>
            <th onclick="sort('latlng_finish')">GPS cieľ</th>
            <th onclick="sort('hodnotenie')">Hodnotenie</th>
            <th onclick="sort('poznamka')">Poznámka</th>
            <th onclick="sort('rychlost')">Priemerná rýchlosť</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <p>
        Priemerný počet kilometrov na jeden tréning je <span id="priemer"></span>
    </p>
    <input type="button" value="Stiahnuť ako PDF" onclick="createPdf()">
</div>
</body>
</html>