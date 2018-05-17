<?php
use PHPMailer\PHPMailer\PHPMailer;      //includy pre phpmailer
use PHPMailer\PHPMailer\Exception;
include_once "../vendor/autoload.php";

include_once "../config.php";
include_once "db.php";
include_once "../scripts/geocoding.php";


if(isset($_POST['skolaadresa'])) {
    insertNewUser($_POST['priezvisko'],$_POST['meno'],$_POST['email'],
        $_POST['skolameno'],$_POST['skolaadresa'],$_POST['ulica'],$_POST['psc'],$_POST['mesto'],$_POST['password']);
}

if(isset($_POST['loc'])) {
    if($_POST['loc'] == 0) {
        returnAllUserPositions();
    }
    else if($_POST['loc'] == 1) {
        returnAllSchoolPositions();
    }
}

/*else if(isset($_POST['email'])) {
    checkPasswd($_POST['email'], $_POST['password']);
}*/


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
        //echo "Nenasli sa ziadne udaje";
        return false;
    }
    else {
        $passwd = hash('sha512', $passwd);
        //echo $result;
        if($result['passwd'] === $passwd) {
            //echo "Heslo je spravne";
            return true;
        }
        else {
            //echo "Heslo je chybne";
            return false;
        }
    }
}
function returnAllUserPositions() {
    $rows = getAllLatLngFromUsers();
    echo json_encode($rows);
}

function returnAllSchoolPositions() {
    $rows = getAllLatLngFromSchool();
    echo json_encode($rows);
}


//funkcia na vkladanie zaznamu do databazy skol
function insertIntoSchool($name, $addr) {
    $latlng = "";
    $j = getLatLngFromAddr($addr);
    if(!empty($j->results)) {
        $loc = $j->results[0]->geometry->location;
        $latlng = $loc->lat . "," . $loc->lng;
    }
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
<<<<<<< HEAD
=======
    $latlng = "";
>>>>>>> 9428a4befc2f856c07a6793230f30a76d759a911
    $j = getLatLngFromAddr($street . ", " . $city . ", " . $psc);
    if(!empty($j->results)) {
        $loc = $j->results[0]->geometry->location;
        $latlng = $loc->lat . "," . $loc->lng;
    }
    $role = "user";
    $hash = md5( rand(0,1000) ); // hash na verifikaciu mailu
    $status = 0;
    $conn = connect();
    $sql = "INSERT INTO users(id_school,name,surname,city,street,psc,email,passwd,role,latlng) ".
        "VALUES(".$id_school.",'".$name."','".$surname."','".$city."','".$street."','".$psc."','".$email."','".$passwd."','".$role."','".$latlng."');";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>";
        $sql = "INSERT INTO aktivacia(id,hash,active) ".
        "VALUES('".$last_id."','".$hash."','".$status."');";
        $conn->query($sql);
        sendVerificationEmail($email,$hash,$last_id);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }

    $conn->close();
}

function getPasswdByEmail($email) {
    $conn = connect();
    $sql = "SELECT passwd FROM users WHERE email='".$email."';";
<<<<<<< HEAD

    $result = $conn->query($sql);
    $row = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
}

function getAllLatLngFromUsers() {
    $conn = connect();
    $sql = "SELECT latlng FROM users;";
    $result = $conn->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()) {
        array_push($rows, $row);
    }
    $conn->close();
    return $rows;
}

function getAllLatLngFromSchool() {
    $conn = connect();
    $sql = "SELECT latlng FROM school;";
    $result = $conn->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()) {
        array_push($rows, $row);
    }
    $conn->close();
    return $rows;
}

function getAccType($email){
    $conn = connect();
    $sql = "SELECT role FROM users WHERE email='$email'";

    $result = $conn->query($sql);
=======

    $result = $conn->query($sql);
    $row = 0;
>>>>>>> 9428a4befc2f856c07a6793230f30a76d759a911
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
<<<<<<< HEAD
=======
}

function getAllLatLngFromUsers() {
    $conn = connect();
    $sql = "SELECT latlng FROM users;";
    $result = $conn->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()) {
        array_push($rows, $row);
    }
    $conn->close();
    return $rows;
>>>>>>> 9428a4befc2f856c07a6793230f30a76d759a911
}

function getAllLatLngFromSchool() {
    $conn = connect();
    $sql = "SELECT latlng FROM school;";
    $result = $conn->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()) {
        array_push($rows, $row);
    }
    $conn->close();
    return $rows;
}

<<<<<<< HEAD
function sendVerificationEmail($email,$hash,$id){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username='webte2final@gmail.com';
    $mail->Password='final123456';
    $mail->setFrom('no-reply@webte2.sk');
    $mail->Subject='Signup | Verification';
    $mail->Body= '
     
    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
    '.PHP_EOL.'
    ------------------------
    Username: '.$email.'
    ------------------------
     '.PHP_EOL.'
    Please click this link to activate your account:
    http://http://147.175.98.141/final/app/verify.php?email='.$email.'&hash='.$hash.'&id='.$id.'';
    $mail->AddAddress($email);

    $mail->Send();
   
}

function getAccId($email){
    $conn = connect();
    $sql = "SELECT id FROM users WHERE email='$email'";

=======
function getAccType($email){
    $conn = connect();
    $sql = "SELECT role FROM users WHERE email='$email'";

>>>>>>> 9428a4befc2f856c07a6793230f30a76d759a911
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
}

<<<<<<< HEAD
function insertIntoTraces($user_id, $from, $to){

    $conn = connect();
    $sql = "INSERT INTO traces (id_autor, from_t, to_t ) VALUES ('$user_id', '$from', '$to')";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "0";
    }
    $conn->close();
}

function getAllTraces(){
    session_start();
    $user_id = $_SESSION['user_id'];
    $conn = connect();
    $sql = "SELECT from_t, to_t FROM traces WHERE id_autor = '$user_id'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row['from_t']."</td><td>".$row['to_t']."</td><td></td><td></td></tr>";
        }
    }
    $conn->close();
=======

function sendVerificationEmail($email,$hash,$id){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username='webte2final@gmail.com';
    $mail->Password='final123456';
    $mail->setFrom('no-reply@webte2.sk');
    $mail->Subject='Signup | Verification';
    $mail->Body= '
     
    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
    '.PHP_EOL.'
    ------------------------
    Username: '.$email.'
    ------------------------
     '.PHP_EOL.'
    Please click this link to activate your account:
    http://http://147.175.98.141/final/app/verify.php?email='.$email.'&hash='.$hash.'&id='.$id.'';
    $mail->AddAddress($email);

    $mail->Send();
   
}

function getAccId($email){
    $conn = connect();
    $sql = "SELECT id FROM users WHERE email='$email'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
>>>>>>> 9428a4befc2f856c07a6793230f30a76d759a911
}