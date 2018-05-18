<!DOCTYPE html>
<html lang="sk">
<head>
	<title>Pridanie novinky</title>
	<script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="../css/style.css" type="text/css" rel="stylesheet">
    <script src="news.js"></script>
</head>
<body>

	<header class="jumbotron">
    <h1>Pridanie aktuality</h1>
	</header>
    <nav>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link " href="../app/app_admin.php">Aplikácia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="../app/vykony_admin.php">Výkony</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../news/news-add.php">Aktuality</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="../app/nastavenia.php">Nastavenia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="change_password.php">Zmena hesla</a>
        </li>
        <li class="nav-item">
                <a class="nav-link" href="admin_dokumentacia.php">Dokumentácia</a>
            </li>
        <li class="nav-item">
            <a class="nav-link " href="../app/signout.php">Odhlásiť sa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"><?php session_start(); echo $_SESSION['user_login']." (".$_SESSION['user_type'].")"; ?></a>
        </li>
    </ul>
</nav>

	<div class="container">

	<div id="alert-success2" class="alert alert-success alert-dismissible">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>OK!</strong> Novinka uspesne pridana.
    </div>

    <div id="alert-fail2" class="alert alert-danger alert-dismissible">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Hups!</strong> Pri pridavani novinky sa objavila chyba. Skuste to znova prosim.
    </div>

    <div class="col-lg-6 col-lg-offset-2">
    <form action="../scripts/add_news.php" method="post">
        <div class="form-group">
            <label for="title">Nazov: </label>
            <input id="title" type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label for="text">Text: </label><br>
              <textarea class="form-control" rows="5" id="text" name="news_text"></textarea>
        </div>
        <input type="submit" name="pridat" value="Pridat" id="news_button" class="btn btn-primary">
    </form>
</div>
</div>
</body>
</html>