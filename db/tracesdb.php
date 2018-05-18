<?php
include_once "db.php";
session_start();

if(isset($_POST['postfrom']) && isset($_POST['postto'])) {
    getDoneFromTracesByUserId($_SESSION['user_id'],$_POST['postfrom'],$_POST['postto']);
}

function getDoneFromTracesByUserId($user_id,$from,$to) {
    $conn = connect();
    $sql = "SELECT done FROM traces WHERE (id_autor=".$user_id." OR mode='verejny') AND from_t='".$from."' AND to_t='".$to."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        echo $row['done'];
    }
    $conn->close();

}