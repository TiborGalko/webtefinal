<?php
include_once "../scripts/geocoding.php";
include_once "db.php";

session_start();

if(isset($_POST['kilometre'])) {
    if(isset($_SESSION['user_id'])) {
        vytvoritVykon($_POST['kilometre']); //staci lebo ostatne niesu required
    }
}

if(isset($_POST['columnName'])) {
    $columnName = $_POST['columnName'];
    $order = $_POST['order'];
    if(isset($_SESSION['user_id'])) {
        $result = getVykonyByUserIdSorted($_SESSION['user_id'],$columnName,$order);
        echo $result;
    }

}

//funkcia na nastavenie premennych pre vkladanie vykonu
function vytvoritVykon($km) {
    $latlngStart = "NULL";
    $latlngCiel = "NULL";
    $casStartu = "0";
    $casKonca = "0";
    $rychlost = "0";
    $hodnotenie = "NULL";
    $poznamka = "NULL";
    $den = "NULL";
    $user_id = $_SESSION['user_id'];

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

        $t = (strtotime($casKonca) - strtotime($casStartu)) / 3600;
        if($t != 0) {
            //v = s/t, km/h
            $rychlost = $km / $t;
        }
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
    //header("Location: ../app/app_user.php"); TODO
}

//vkladanie do tabulky vykonov
function insertIntoVykony($km, $user_id, $den, $casStart, $casKoniec, $miestoStart, $miestoCiel, $hodnotenie, $poznamka, $rychlost) {
    $conn = connect();
    $sql = "INSERT INTO vykony(user_id, kilometre, den, cas_start, cas_finish, latlng_start, latlng_finish, hodnotenie, poznamka, rychlost) ".
        "VALUES(".$user_id.",".$km.",'".$den."','".$casStart."','".$casKoniec."','".$miestoStart."','".$miestoCiel."','".$hodnotenie."','".$poznamka."',".$rychlost.")";
    if ($conn->query($sql) === TRUE) {
        echo "Záznam úspešne zapísaný" . "<br>";
    } else {
        echo "Chyba: " . $sql . "<br>" . $conn->error . "<br>";
    }
    $conn->close();
}

//vrati sortnutu tabulku vykonov
function getVykonyByUserIdSorted($user_id, $sort = "id", $order = "asc") {
    $conn = connect();

    $sql = "SELECT * FROM vykony WHERE user_id=".$user_id . " ORDER BY " . $sort . " " . $order;
    $result = $conn->query($sql);
    $output = "";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>".$row['kilometre']."</td>" .
                "<td>".$row['den']."</td>" .
                "<td>".$row['cas_start']."</td>" .
                "<td>".$row['cas_finish']."</td>" .
                "<td>".$row['latlng_start']."</td>" .
                "<td>".$row['latlng_finish']."</td>" .
                "<td>".$row['hodnotenie']."</td>" .
                "<td>".$row['poznamka']."</td>" .
                "<td>".$row['rychlost']."</td>";
            $output .= "</tr>";
        }
    }
    else {
        echo "Chyba: " . $sql . "<br>" . $conn->error . "<br>";
    }
    $conn->close();
    return $output;
}

function getPriemernuVzdialenostByUserId($user_id) {
    $priemer = 0;
    $conn = connect();
    $sql = "SELECT kilometre FROM vykony WHERE user_id=".$user_id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $priemer += $row['kilometre'];
        }
        $priemer = $priemer / $result->num_rows; //vypocet priemeru
    }
    else {
        echo "Chyba: " . $sql . "<br>" . $conn->error . "<br>";
    }
    $conn->close();
    return $priemer;
}