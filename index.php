<?php

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Úvodná stránka</title>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpnArBmSGhkTmYTQRXiDZMi9h6xj1LwHA"></script>

    <!-- news script -->
    <script src="news/news-script.js"></script>
    <script src="libs/jquery.redirect-master/jquery.redirect.js"></script>


    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Úvodná stránka</h1>
</header>
<div>
<label for="sel">Výber zobrazenia: </label>
<select id="sel">
    <option>Miesta</option>
    <option>Školy</option>
</select>
<input type="button" value="Zobraziť">
</div>
<div id="map"></div>


<a href="user/prihlasenie.html">Prihlásiť sa</a>
<a href="user/registracia.html">Registrovať sa</a>


<script>
    let map;

    //event listener na nacitanie mapy po skonceni nacitania
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        initMap();
    }
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 48.669026, lng: 19.69902400000001}
        });
    }
</script>


<!-- news -->
<!-- vytvara elemnty s ID 1,2,... kvoli tomu aby sa dalo dobre selectovat z DB, prosim taketo idcka nepouzivajte -->
<h2>Aktuality</h2>
<?php
    
    include "config.php";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM news ORDER BY created DESC LIMIT 3";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $text = $row["text"];

            if(strlen($text) > 150){
                $text = substr($text, 0, 150);
                $text .= "...";
            }
            echo "<b>".$row["title"]."</b><br>".$text."<span id=".$row["id"]." class='news-clickable'> citaj dalej</span><br>".$row["id_autor"]."<br>".$row["created"]."<br>--------------------------------<br>";
        }
        echo "<a href='news/news-all.php'>Zobrazit vsetky novinky</a>";
    } else {
        echo "Ziadne novinky";
    }

    $conn->close();

?>

</body>
</html>

