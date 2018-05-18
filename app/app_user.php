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
                <a class="nav-link" href="user_dokumentacia.php">Dokumentácia</a>
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
        <div id="mapaTras"></div>

        <div class="progress">
            <div id="progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
        </div>
        <span id="progress_text"></span><br>

        <input type="button" name="vykon" id="add_vykon" class="btn btn-primary" value="Pridat vykon">
        <div id="show_vykon">
            <h2>Pridaj vykon</h2>
            <img id="close_icon2" src="../img/close_icon.png" height="25" width="25">
            <form method="post" action="../db/vykonydb.php">
                <div class="form-group">
                    <label for="kilometre">Počet kilometrov: </label>
                    <input id="kilometre" type="text" class="form-control" name="kilometre" required>
                </div>
                <div class="form-group">
                    <label for="den">Deň: </label>
                    <select id="den" class="form-control" name="den">
                        <option value="pon">Pondelok</option>
                        <option value="ut">Utorok</option>
                        <option value="str">Streda</option>
                        <option value="stv">Štvrtok</option>
                        <option value="pi">Piatok</option>
                        <option value="so">Sobota</option>
                        <option value="ne">Nedeľa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="casStart">Čas začiatku: </label>
                    <input id="casStart" type="text" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" name="casStart" title="Formát HH:MM:SS">
                </div>
                <div class="form-group">
                    <label for="casKoniec">Čas konca: </label>
                    <input id="casKoniec" type="text" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" name="casKoniec" title="Formát HH:MM:SS">
                </div>
                <div class="form-group">
                    <label for="miestoStart">Miesto štartu: </label>
                    <input id="miestoStart" type="text" class="form-control" name="miestoStart">
                </div>
                <div class="form-group">
                    <label for="miestoCiel">Miesto cieľa: </label>
                    <input id="miestoCiel" type="text" class="form-control" name="miestoCiel">
                </div>
                <div class="form-group">
                    <label for="hodnotenie">Hodnotenie: </label>
                    <select id="hodnotenie" class="form-control" name="hodnotenie">
                        <option value="1" data-imagesrc="../img/1.png" data-description="1">1</option>
                        <option value="2" data-imagesrc="../img/2.png" data-description="2">2</option>
                        <option value="3" data-imagesrc="../img/3.png" data-description="3">3</option>
                        <option value="4" data-imagesrc="../img/4.png" data-description="4">4</option>
                        <option value="5" data-imagesrc="../img/5.png" data-description="5">5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="poznamka">Poznámka: </label>
                    <textarea id="poznamka" rows="5" cols="20" class="form-control" name="poznamka" placeholder="Popíšte svoj tréning" maxlength="150"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Uložiť">
                <input type="hidden" name="from" id="hidden_from">
                <input type="hidden" name="to" id="hidden_to">
            </form>
        </div>

        



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
    <p id="cToken" style="display:none"></p> <!-- neviditelne polia pre jquery-->
    <p id="nToken" style="display:none"></p>
    <header>
        <h2>Tabuľka trás</h2>
    </header>
    <table class="table tablesorter" id="traces_table">
        <thead>
            <tr>
                <th>Odkiaľ</th>
                <th>Kam</th>
                <th>Aktívna/Neaktívna</th>
                <th>Mód</th>
            </tr>            
        </thead>
        <tbody id="traces_body">
            <?php getAllPrivateTraces();  ?>
            <?php getAllPublicTraces();  ?>
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
                echo "<b>" . $row["title"] . "</b><br>" . $text . "<span id=" . $row["id"] . " class='news-clickable'> citaj dalej</span><br><span class='autor'>" . $row["autor"] . "</span><br><i>" . $row["created"] . "</i><br><hr>";
            }
            echo "<a href='../news/news-all.php'>Zobrazit vsetky novinky</a><br><br>";
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
        var stopLng;
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;

        //event listener na nacitanie mapy po skonceni nacitania
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            initMap();
        }
        function initMap() {
            
            mapaTras = new google.maps.Map(document.getElementById('mapaTras'), {
                zoom: 7,
                center: {lat: 48.669026, lng: 19.69902400000001}
            });
            directionsDisplay.setMap(mapaTras);            
            

            google.maps.event.addListener(mapaTras, "click", function (e) {
                //lat and lng is available in e object
                let latLng = e.latLng;              

                if((count % 2) === 1){
                    startLat = latLng.lat();
                    startLng = latLng.lng();
                    $("#from").val(latLng.lat()+","+latLng.lng()); 
                } else {
                    stopLat = latLng.lat();
                    stopLng = latLng.lng();
                    $("#to").val(latLng.lat()+","+latLng.lng()); 
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                }
                count++;
            });  
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
               directionsService.route({
                origin: {lat: startLat  , lng: startLng},
                destination: {lat: stopLat, lng: stopLng},
                travelMode: 'WALKING'
            }, function(response, status) {
              if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
            });
        }

        function getDistance(){
            $("#hidden_from").val(startLat+","+startLng);
            $("#hidden_to").val(stopLat+","+stopLng);
            var request = {
                origin: {lat: startLat  , lng: startLng},
                destination: {lat: stopLat, lng: stopLng},
                travelMode: "WALKING"
            };

            directionsService.route(request, function(result, status){
                if(status == "OK"){
                    var distance = parseInt(result.routes[0].legs[0].distance.text); 
                    var from = startLat+","+startLng;   
                    var to = stopLat+","+stopLng;      

                    $.ajax({
                        url: "../db/tracesdb.php",
                        method: "POST",
                        data: {postfrom: from, postto: to},
                        success: function(data) {   
                            var done = parseInt(data); 
                            var result = Math.round((done/distance)*100);
                            if(result >= 100){
                                result = 100;
                                $("#progress_text").html("Gratulujem, zvladli ste celu trasu!");
                            } else {
                                $("#progress_text").html("Na tejto trase musite zvladnut este " + (distance-done) + " km.");
                            }
                            $("#progress_bar").attr("aria-valuenow", result);
                            $("#progress_bar").attr("style", "width: " + result + "%");
                            
                        },
                        error: function(){
                        }
                    });                             
                }
            });
        }    
    

   </script>
   <script>
        $('#hodnotenie').ddslick({
         onSelected: function(selectedData){
        //callback function: do something with selectedData;
    }   
});



   /*
        $().ready(function () {
            setToken();
            pollServer();
        });

        function pollServer()
        {   
            getToken();
            var nToken = $('#nToken').text();
            var cToken = $('#cToken').text();
            if (cToken !== nToken)
            {
                window.setTimeout(function () {
                    $.ajax({
                        url: "../scripts/dynamic_update.php",
                        type: "POST",
                        success: function (result) {
                            $("#traces_table").html(result)
                            setToken();
                            pollServer();

                        },
                        error: function () {
                            //ERROR HANDLING
                            pollServer();
                        }});
                }, 2500);
            }
            window.setTimeout(function () {pollServer();}, 2500);
        }

        function setToken(){
            jQuery.get('token.txt', function(txt){
                $('#cToken').text(txt);
            });
        }

        function getToken(){
            jQuery.get('token.txt', function(txt){
                $('#nToken').text(txt);
            });

        }*/
    </script>
</div>
</body>
</html>