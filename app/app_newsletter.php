<?php
session_start();

include_once "../db/usersdb.php";
include_once "../db/db.php";

$tmp = $_POST['newsletter'];
$mail = $_SESSION['user_login'];
$conn = connect();
if($tmp==1){
	//prida mail do db na odber newslleteru
	$sql = "select mail from newsletter where mail='".$mail."';";
	$result = $conn->query($sql);
	if ($result->num_rows == 0) {
		$sql = "insert into newsletter(mail) values('".$mail."');";
		$conn->query($sql);
		header("Location: newsletter.php?status=1");
	}else{
		header("Location: newsletter.php?status=3");
	}

}else{
	if($tmp == 0){
		$sql = "SELECT mail from newsletter WHERE mail='".$mail."';";
		$result = $conn->query($sql);
		var_dump($result);
		if ($result->num_rows > 0) {
			$sql = "delete from newsletter where mail='".$mail."';";
			$conn->query($sql);
			header("Location: newsletter.php?status=0");
		}else{
			header("Location: newsletter.php?status=4");
		}

	}
}
/*
$sql = "select hash from aktivacia where id='".$_SESSION['user_id']."';";
$conn = connect();
$result = $conn->query($sql);
$row = $result->fetch_assoc();
*/

//sendVerificationEmail($_SESSION['user_login'],$row['hash'],$_SESSION['user_id']);
//header("Location: app_aktivuj_email.php?status=ok");