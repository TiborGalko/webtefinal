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

<a href="prihlasenie.html">Prihlásiť sa</a>
<a href="registracia.html">Registrovať sa</a>

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
</body>
</html>

