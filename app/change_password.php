<?php

include_once "../db/usersdb.php";
include_once "../db/db.php";  

session_start();

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Zmena hesla</title>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <!-- news script -->
    <script src="../news/news-script.js"></script>
    <script src="../libs/jquery.redirect-master/jquery.redirect.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpnArBmSGhkTmYTQRXiDZMi9h6xj1LwHA&libraries=places"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="add_trace.js"></script>  
    <script src="../__jquery.tablesorter/jquery.tablesorter.js"></script> 

        

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <header class="jumbotron">
        <h1 class="text-center">Zmena hesla</h1>
    </header>
    
    <div class="container">
        <div>
            <div>
            <form method="post" action="../db/usersdb.php">
                <div class="form-group">
                    <label for="heslo">Nove heslo </label>
                    <input id="heslo" type="password" class="form-control" name="zmen_heslo" autocomplete="off" required>
                </div>
               
                <input type="submit" class="btn btn-primary" value="Zmenit">
            </form>
                <a href="app_user.php">Späť do aplikácie</a>
        </div>
       
</div>
</div>
</body>
</html>