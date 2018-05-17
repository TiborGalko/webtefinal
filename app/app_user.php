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
            <a class="nav-link active" href="vykony_user.php">Výkony</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="newsletter.php">Newsletter</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="signout.php">Odhlásiť sa</a>
        </li>
    </ul>
</nav>
<div class="container">
    <div>
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
                <input id="casStart" type="text" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" name="casStart" title="Formát HH:MM">
            </div>
            <div class="form-group">
                <label for="casKoniec">Čas konca: </label>
                <input id="casKoniec" type="text" class="form-control" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" name="casKoniec" title="Formát HH:MM">
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
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="poznamka">Poznámka: </label>
                <textarea id="poznamka" rows="5" cols="20" class="form-control" name="poznamka" placeholder="Popíšte svoj tréning" maxlength="150"></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Uložiť">
        </form>
    </div>

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
    <header>
        <h2>Tabuľka trás</h2>
    </header>
    <table class="table" id="traces_table">
        <thead>
        <tr>
            <th>Odkiaľ</th>
            <th>Kam</th>
            <th>Aktívna/Neaktívna</th>
            <th>Mód</th>
        </tr>
        <?php //getAllTraces();  ?>
        </thead>
        <tbody>
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
                    echo "<b>" . $row["title"] . "</b><br>" . $text . "<span id=" . $row["id"] . " class='news-clickable'> citaj dalej</span><br>" . $row["id_autor"] . "<br>" . $row["created"] . "<br>--------------------------------<br>";
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

        autocomplete1 = new google.maps.places.Autocomplete(start, options);
        autocomplete2 = new google.maps.places.Autocomplete(ciel, options);

        //event listener na nacitanie mapy po skonceni nacitania
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            initMap();
        }
        function initMap() {
            map = new google.maps.Map(document.getElementById('mapaTras'), {
                zoom: 7,
                center: {lat: 48.669026, lng: 19.69902400000001}
            });
        }



    </script>
</div>
</body>
</html>