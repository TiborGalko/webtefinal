<?php
include_once "../config.php";
include_once "db.php";
include_once "../scripts/geocoding.php";

//funkcia vlozi do databazy skol a userov nove zaznamy
function insertNewUser($surname,$name,$email,$schoolname,$schooladdr,$street,$psc,$city) {
    $id_school = insertIntoSchool($schoolname,$schooladdr);
    insertIntoUsersDefaultPasswd($id_school, $surname, $name, $email, $street, $psc, $city);
}

//funkcia na vkladanie zaznamu do databazy skol
function insertIntoSchool($name, $addr) {
    $j = getLatLngFromAddr($addr);
    $loc = $j->results[0]->geometry->location;
    $latlng = $loc->lat.",".$loc->lng;

    $conn = connect();
    $sql = "INSERT INTO school(name,address,latlng) ".
        "VALUES('".$name."','".$addr."','".$latlng."');";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }
    $conn->close();

    return $last_id;
}

//funkcia na vkladanie uzivatelov s zakladnym heslom user123
function insertIntoUsersDefaultPasswd($id_school, $surname, $name, $email, $street, $psc, $city) {
    $passwd = hash('sha512', "user123"); //default heslo
    $j = getLatLngFromAddr($street . ", " . $city . ", " . $psc);
    $loc = $j->results[0]->geometry->location;
    $latlng = $loc->lat.",".$loc->lng;

    $role = "user";
    $conn = connect();
    $sql = "INSERT INTO users(id_school,name,surname,city,street,psc,email,passwd,role,latlng) ".
        "VALUES(".$id_school.",'".$name."','".$surname."','".$city."','".$street."','".$psc."','".$email."','".$passwd."','".$role."','".$latlng."');";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }

    $conn->close();
}

//funkcia na vkladanie uzivatelov s vlastnym heslom
function insertIntoUsers($surname, $name, $email, $passwd, $street, $psc, $city) {

}



