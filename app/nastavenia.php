<?php
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Aplikácia - nastavenia</title>
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header class="jumbotron">
    <h1>
        Aplikácia - nastavenia
    </h1>
</header>
<nav>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="app_admin.php">Aplikácia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="vykony_admin.php">Výkony</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../news/news-add.php">Aktuality</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="nastavenia.php">Nastavenia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="change_password.php">Zmena hesla</a>
        </li>
        <li class="nav-item">
                <a class="nav-link" href="admin_dokumentacia.php">Dokumentácia</a>
            </li>
        <li class="nav-item">
            <a class="nav-link" href="signout.php">Odhlásiť sa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"><?php session_start(); echo $_SESSION['user_login']." (".$_SESSION['user_type'].")"; ?></a>
        </li>
    </ul>
</nav>
<div class="container">
    <header>
        <h2>Registrácia uživateľov zo súboru</h2>
    </header>
    <div class="col-lg-6 col-lg-offset-2">
    <form action="../scripts/upload.php" method="post" enctype="multipart/form-data">
        <div class="form-row">
        <div class="form-group col-md-6">
            <label for="delim">Oddeľovač: </label>
            <input id="delim" type="text" class="form-control" name="delim">
        </div>
        <div class="form-group col-md-6">
            <label for="riadok">Od riadka: </label>
            <input id="riadok" type="number" class="form-control" name="riadok">
        </div>
        </div>
        <div class="form-group">
            <label for="encoding">Kódovanie: </label>
            <select id="encoding" class="form-control" name="encoding">
                <option value="utf8">UTF-8</option>
                <option value="win1250">Windows 1250</option>
            </select>
        </div>

        Select file to upload:
        <input type="file" name="file" id="file">
        <input type="submit" class="btn btn-primary" value="Upload" name="submit">
    </form>
    </div>
</div>
</body>
</html>
