<?php
include_once "../db/usersdb.php";
include_once "../db/db.php"; 


// skontroluje ci je email verifikovany
$conn = connect();
$id = $_GET['id'];
$hash = $_GET['hash'];
$sql = "SELECT id, hash, active FROM aktivacia WHERE id='".$id."' AND hash='".$hash."' AND active='0';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
        //$row = $result->fetch_assoc();
	$sql = "UPDATE aktivacia SET active='1' WHERE id='".$id."' AND hash='".$hash."' AND active='0';";
	$conn->query($sql);
	//echo "aktivovane";
    header("Location: ../app/app_user.php");

    }
    else{
        //echo "error";
        header("Location: ../index.php");
    }

$conn->close();
