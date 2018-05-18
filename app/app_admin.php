<?php

    include_once "../db/usersdb.php";
    include_once "../db/db.php";  

    session_start();

    if(!isset($_SESSION['user_login'])){
        header("Location: ../index.php");
    }

    if(strcmp($_SESSION['user_type'], "admin") != 0){
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpnArBmSGhkTmYTQRXiDZMi9h6xj1LwHA"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <script src="add_trace.js"></script>
    <script type="text/javascript" src="../__jquery.tablesorter/jquery.tablesorter.js"></script> 

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header class="jumbotron">
    <h1>Aplikácia</h1>
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
            <a class="nav-link active" href="../news/news-add.php">Aktuality</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="nastavenia.php">Nastavenia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="change_password.php">Zmena hesla</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="signout.php">Odhlásiť sa</a>
        </li>
    </ul>
</nav>
<div class="container">
    <div id="mapaTras"></div>



     <!--         Pridavanie trasy           -->

    <div id="alert-success" class="alert alert-success alert-dismissible">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>OK!</strong> Trasa bola uspesne pridana.
    </div>

    <div id="alert-fail" class="alert alert-danger alert-dismissible">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Hups!</strong> Pri pridavani trasy nastala chyba. Skuste to znova prosim.
    </div>

    <input id="show_button" type="button" class="btn btn-primary" value="Pridat trasu">

    <div id="add_form">
    <h2>Pridanie trasy</h2>
    <img id="close_icon" src="../img/close_icon.png" height="25" width="25">
    <form>
        <div class="form-group">
            <label for="from">Odkial </label>
            <input id="from" type="text" class="form-control" name="from">
        </div>
        <div class="form-group">
            <label for="to">Kam </label>
            <input id="to" type="text" class="form-control" name="to">
        </div>
        <input id="add_button" type="button" class="btn btn-primary" value="Pridat">
    </form>
    </div>


    <!--            TABULKA     TRAS            -->

    <div>
    <label for="filterTras">Filtrovanie trás podla uzivatela</label>
        <input type="text" name="user" class="form-control" style="width: 250px;" id="filter_text">
        <input type="button" id="filter_button" class="btn btn-primary" value="Filtrovat"><br>
        <span id="filter_cancel">Zrusit filter</span>
    </div>
    <header>
        <h2>Tabuľka trás</h2>
    </header>
    <table class="table" id="traces_table">
        <thead>
        <tr>
            <th>Odkiaľ</th>
            <th>Kam</th>
            <th>Mód</th>
            <th>Uživateľ</th>
        </tr>        
        </thead>
        <tbody id="traces_body">
        <?php getAllTraces();  ?>
        </tbody>
    </table>

    <aside>
        <?php        

        // ZOBRAZOVANIE AKTUALIT

            echo "<h2>Aktuality</h2>";

            // Create connection
            $conn = connect();
            $sql = "SELECT * FROM news ORDER BY created DESC LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {

                    $text = $row["text"];

                    if (strlen($text) > 150) {
                        $text = substr($text, 0, 150);
                        $text .= "...";
                    }
                    echo "<b>" . $row["title"] . "</b><br>" . $text . "<span id=" . $row["id"] . " class='news-clickable'> citaj dalej</span><br>" . $row["autor"] . "<br>" . $row["created"] . "<br>--------------------------------<br>";
                }
                echo "<a href='../news/news-all.php'>Zobrazit vsetky novinky</a>";
            } else {
                echo "Ziadne novinky";
            }

            $conn->close();

        ?>
    </aside>
    <script>
        let mapaTras;

        let start = document.getElementById('miestoStart');
        let ciel = document.getElementById('miestoCiel');
        let options = {
            types: ['establishment']
        };

        var count = 1;
        var startLat;
        var startLng;
        var stopLat;
        var stoptLng;

        //event listener na nacitanie mapy po skonceni nacitania
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            initMap();
        }
        function initMap() {
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            mapaTras = new google.maps.Map(document.getElementById('mapaTras'), {
                zoom: 7,
                center: {lat: 48.669026, lng: 19.69902400000001}
            });
            directionsDisplay.setMap(mapaTras);

            google.maps.event.addListener(mapaTras, "click", function (e) {
                //lat and lng is available in e object
                let latLng = e.latLng;              

                if((count % 2) == 1){
                    startLat = latLng.lat();
                    startLng = latLng.lng();
                    $("#from").val(latLng.lat()+","+latLng.lng()); 
                } else {
                    stopLat = latLng.lat();
                    stoptLng = latLng.lng();
                    $("#to").val(latLng.lat()+","+latLng.lng()); 
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                }
                count++;
            });

            

            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
               directionsService.route({
                origin: {lat: startLat  , lng: startLng},
                destination: {lat: stopLat, lng: stoptLng},
                travelMode: 'WALKING'
            }, function(response, status) {
              if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
            });
        
        }
       }

   </script>
</div>
</body>
</html>