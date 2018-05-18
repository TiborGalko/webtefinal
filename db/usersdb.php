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
    echo '<script type="text/javascript">
    window.location = "index.php"
    </script>';
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
    $last_id = 0;
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
    $latlng = "";
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
    "VALUES('".$id_school."','".$name."','".$surname."','".$city."','".$street."','".$psc."','".$email."','".$passwd."','".$role."','".$latlng."');";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>";
        $sql = "INSERT INTO aktivacia(id,hash,active) ".
        "VALUES('".$last_id."','".$hash."','".$status."');";
        $conn->query($sql);
        sendVerificationEmail($email,$hash,$last_id);

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        $conn->close();
        return false;
    }

    $conn->close();
    return true;
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

function getAllUserInfoFromUsers() {
    $conn = connect();
    $sql = "SELECT id,email,name,surname,role FROM users;";
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
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    return $row;
}


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
}

function getAllPrivateTraces(){
    session_start();
    $user_id = $_SESSION['user_id'];

    $conn = connect();
    $sql = "SELECT * FROM traces WHERE id_autor='$user_id'";
    $result = $conn->query($sql);

    $sql2 = "SELECT * FROM users WHERE id='$user_id'";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
    }

    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            if($row['id'] == $row2['active_trace']){
                echo "<tr><td>".$row["from_t"]."</td><td>".$row["to_t"]."</td><td class='td-active'>Aktivna</td><td>".$row['mode']."</td></tr>";
            } else {
                echo "<tr><td>".$row["from_t"]."</td><td>".$row["to_t"]."</td><td class='td-noactive'>Neaktivna</td><td>".$row['mode']."</td></tr>";
            }
        }
    } 
    $conn->close();
}

function insertIntoTraces($user_id, $from, $to, $mode){
    $conn = connect();

    session_start();
    $user_type = $_SESSION['user_type'];

    if(strcmp($user_type, "user") == 0){
    $sql = "INSERT INTO traces (id_autor, from_t, to_t, mode) VALUES ('$user_id', '$from', '$to', '$mode')";

    $conn->query($sql);
    $last_id = $conn->insert_id;
    
    $sql = "SELECT * FROM traces WHERE id='$last_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["from_t"]."</td><td>".$row["to_t"]."</td><td class='td-noactive'>Neaktivna</td><td>".$row['mode']."</td></tr>";            
        }
    } 
    } else {
        $sql = "INSERT INTO traces (id_autor, from_t, to_t, mode) VALUES ('$user_id', '$from', '$to', '$mode')";

        $conn->query($sql);
        $last_id = $conn->insert_id;
    
        $sql = "SELECT * FROM traces t INNER JOIN users u ON t.id_autor = u.id WHERE t.id='$last_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['from_t']."</td><td>".$row['to_t']."</td><td>".$row['mode']."</td><td>".$row['email']."</td></tr>";            
        }
        }
    }

    $conn->close();
}

function getAllPublicTraces(){
    session_start();
    $user_id = $_SESSION['user_id'];

    $conn = connect();
    $sql = "SELECT * FROM traces WHERE mode='verejny'";
    $result = $conn->query($sql);

    $sql2 = "SELECT * FROM users WHERE id='$user_id'";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
    }

    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            if($row['id'] == $row2['active_trace']){
                echo "<tr><td>".$row["from_t"]."</td><td>".$row["to_t"]."</td><td class='td-active'>Aktivna</td><td>".$row['mode']."</td></tr>";
            } else {
                echo "<tr><td>".$row["from_t"]."</td><td>".$row["to_t"]."</td><td class='td-noactive'>Neaktivna</td><td>".$row['mode']."</td></tr>";
            }
        }
    } 
    $conn->close();
}

function getAllTraces(){
    $conn = connect();
    $sql = "SELECT * FROM traces t INNER JOIN users u ON t.id_autor = u.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row['from_t']."</td><td>".$row['to_t']."</td><td>".$row['mode']."</td><td>".$row['email']."</td></tr>";
        }
    } 
    $conn->close();
}

function getFilterTraces($filter){

    $conn = connect();
    $sql = "SELECT * FROM traces t INNER JOIN users u ON t.id_autor = u.id WHERE u.email='$filter'";
    $result = $conn->query($sql);

    echo "<thead>
        <tr>
            <th>Odkiaľ</th>
            <th>Kam</th>
            <th>Mód</th>
            <th>Uživateľ</th>
        </tr>        
        </thead>";

    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row['from_t']."</td><td>".$row['to_t']."</td><td>".$row['mode']."</td><td>".$row['email']."</td></tr>";
        }
    } 
    $conn->close();
}

function insertIntoNews($user_id, $title, $text){

    $conn = connect();
    $sql = "INSERT INTO news (id_autor, title, text, created) VALUES ('$user_id', '$title', '$text', NOW())";

   $conn->query($sql);

    $conn->close();

}