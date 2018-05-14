<?php
include_once "../config.php";
include_once "db.php";
include_once "../scripts/geocoding.php";

if(isset($_POST['skolaadresa'])) {
    insertNewUser($_POST['priezvisko'],$_POST['meno'],$_POST['email'],
        $_POST['skolameno'],$_POST['skolaadresa'],$_POST['ulica'],$_POST['psc'],$_POST['mesto'],$_POST['password']);
}
else if(isset($_POST['email'])) {
    checkPasswd($_POST['email'], $_POST['password']);
}


//funkcia vlozi do databazy skol a userov nove zaznamy
//ked sa pouziva csv je passwd user123
function insertNewUser($surname,$name,$email,$schoolname,$schooladdr,$street,$psc,$city,$passwd) {
    $id_school = insertIntoSchool($schoolname,$schooladdr);
    insertIntoUsers($id_school, $surname, $name, $email, $passwd,$street, $psc, $city);
}

//funkcia skontroluje ci je heslo spravne
function checkPasswd($email, $passwd) {
    $result = getPasswdByEmail($email);
    if($result == 0) {
        echo "Nenasli sa ziadne udaje";
    }
    else {
        $passwd = hash('sha512', $passwd);
        if($result['passwd'] === $passwd) {
            echo "Heslo je spravne";
        }
        else {
            echo "Heslo je chybne";
        }
    }
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

//funkcia na vkladanie uzivatelov
function insertIntoUsers($id_school, $surname, $name, $email, $passwd, $street, $psc, $city) {
    $passwd = hash('sha512', $passwd);
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

function getPasswdByEmail($email) {
    $conn = connect();
    $sql = "SELECT passwd FROM users WHERE email='".$email."';";

    $result = $conn->query($sql);
    $row = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
}


