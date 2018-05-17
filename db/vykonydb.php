<?php
include_once "../scripts/geocoding.php";
include_once "db.php";

session_start();

if(isset($_POST['kilometre'])) {
    if(isset($_SESSION['user_id'])) {
        vytvoritVykon($_POST['kilometre']); //staci lebo ostatne niesu required
    }
}

//funkcia na nastavenie premennych pre vkladanie vykonu
function vytvoritVykon($km) {
    $latlngStart = "";
    $latlngCiel = "";
    $casStartu = "";
    $casKonca = "";
    $rychlost = "";
    $hodnotenie = "";
    $poznamka = "";
    $den = "";
    $user_id = $_SESSION['user_id'];

    print_r($_POST['miestoStart']);
    if(empty($_POST['miestoStart'])) {
        $j = getLatLngFromAddr($_POST['miestoStart']);
        if(!empty($j->results)) {
            $loc = $j->results[0]->geometry->location;
            $latlngStart = $loc->lat.",".$loc->lng;
        }

    }
    if(!empty($_POST['miestoCiel'])) {
        $j = getLatLngFromAddr($_POST['miestoCiel']);
        if(!empty($j->results)) {
            $loc = $j->results[0]->geometry->location;
            $latlngCiel = $loc->lat.",".$loc->lng;
        }

    }
    if(!empty($_POST['casStart']) && !empty($_POST['casKoniec'])) {
        $casStartu = $_POST['casStart'];
        $casKonca = $_POST['casKoniec'];

        //v = s/t, km/h
        $rychlost = $km / ((strtotime($casKonca) - strtotime($casStartu)) / 3600);
    }
    if(!empty($_POST['hodnotenie'])) {
        $hodnotenie = $_POST['hodnotenie'];
    }
    if(!empty($_POST['poznamka'])) {
        $poznamka = $_POST['poznamka'];
    }
    if(!empty($_POST['den'])) {
        $den = $_POST['den'];
    }
    insertIntoVykony($km,$user_id,$den,$casStartu,$casKonca,$latlngStart,$latlngCiel,$hodnotenie,$poznamka,$rychlost);
}

//vkladanie do tabulky vykonov
function insertIntoVykony($km, $user_id, $den, $casStart, $casKoniec, $miestoStart, $miestoCiel, $hodnotenie, $poznamka, $rychlost) {
    $conn = connect();
    echo "ok";

    $sql = "INSERT INTO vykony(user_id, kilometre, den, cas_start, cas_finish, latlng_start, latlng_finish, hodnotenie, poznamka, rychlost) ".
        "VALUES(".$user_id.",".$km.",'".$den."',".$casStart.",".$casKoniec.",'".$miestoStart."','".$miestoCiel."','".$hodnotenie."','".$poznamka."',".$rychlost.")";
    echo "ok";
    if ($conn->query($sql) === TRUE) {
        echo "Záznam úspešne zapísaný" . "<br>";
    } else {
        echo "Chyba: " . $sql . "<br>" . $conn->error . "<br>";
    }
    echo "ok";
    $conn->close();
}

function getVykonyByUserId($user_id) {
    $conn = connect();

    $sql = "SELECT * FROM vykony WHERE user_id=".$user_id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<tr>";
        while($row = $result->fetch_assoc()) {
            echo "<td>".$row['kilometre']."</td>" .
                "<td>".$row['den']."</td>" .
                "<td>".$row['cas_start']."</td>" .
                "<td>".$row['cas_finish']."</td>" .
                "<td>".$row['latlng_start']."</td>" .
                "<td>".$row['latlng_finish']."</td>" .
                "<td>".$row['hodnotenie']."</td>" .
                "<td>".$row['poznamka']."</td>" .
                "<td>".$row['rychlost']."</td>";
        }
        echo "</tr>";
    }
    else {
        echo "Chyba: " . $sql . "<br>" . $conn->error . "<br>";
    }

    $conn->close();
}