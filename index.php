<?php
    session_start();
    if(isset($_SESSION['user_login']) && ($_SESSION['user_type'] == 'user')) {
        header("Location: app/app_user.php");
    }
    else if(isset($_SESSION['user_login']) && ($_SESSION['user_type'] == 'admin')) {
        header("Location: app/app_admin.php");
    }
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header class="jumbotron">
    <h1>Úvodná stránka</h1>
</header>
<div class="container">
    <div class="container">
        <label for="sel">Výber zobrazenia: </label>
        <select id="sel">
            <option>Miesta</option>
            <option>Školy</option>
        </select>
        <input type="button" value="Zobraziť" class="btn btn-primary" onclick="showMarkers()">
    </div>
    <div id="map"></div>


    <a href="user/prihlasenie.html">Prihlásiť sa</a>
    <a href="user/registracia.html">Registrovať sa</a>


    <script>
        let map;
        let markers = [];

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

        //zobrazenie markerov na mape na uvodnej stranke
        function showMarkers() {
            let select = document.getElementById("sel");

            $.ajax({
                url: "db/usersdb.php",
                type: "post",
                data: {"loc": select.selectedIndex},
                success: function (response) {
                    clearMarkers();
                    markers.length = 0;
                    let r = JSON.parse(response);
                    for (let i = 0; i < r.length; i++) {
                        let loc = r[i].latlng.split(","); //rozdelenie stringu na lat a lng
                        //pridanie markeru
                        let marker = new google.maps.Marker({
                            position: new google.maps.LatLng({lat: parseFloat(loc[0]), lng: parseFloat(loc[1])}),
                            map: map
                        });

                        markers.push(marker);
                    }
                }
            });
        }

        //vymazanie markerov na mape
        function clearMarkers() {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }
    </script>
</div>
</body>
</html>

