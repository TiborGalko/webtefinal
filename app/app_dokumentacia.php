<?php

include_once "../db/usersdb.php";
include_once "../db/db.php";  

session_start();

if(!isset($_SESSION['user_login'])){
    header("Location: ../index.php");
}

if(strcmp($_SESSION['user_type'], "user") != 0){
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Aplikácia</title>
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
    <script type="text/javascript" src="../__jquery.tablesorter/jquery.tablesorter.js"></script> 
    <script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
        

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <header class="jumbotron">
        <h1>Aplikácia</h1>
    </header>
    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="app_user.php">Aplikácia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="vykony_user.php">Výkony</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="newsletter.php">Newsletter</a>
            </li>
            <li class="nav-item">
            <a class="nav-link " href="change_password.php">Zmena hesla</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="signout.php">Odhlásiť sa</a>
            </li>
            <li class="nav-item">
            <a class="nav-link"><?php echo $_SESSION['user_login']." (".$_SESSION['user_type'].")"; ?></a>
        </li>
        </ul>
    </nav>
    <div class="container">
    


    </div>
</body>
</html>