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


<div id="map"></div>

<form>
    <label for="email">Email: </label>
    <input id="email" type="text" name="email">
    <label for="heslo">Heslo: </label>
    <input id="heslo" type="password" name="password">
    <input type="submit" value="Potvrdiť">
</form>

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

