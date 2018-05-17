<?php
session_start();

include_once "../db/usersdb.php";
include_once "../db/db.php";

$sql = "select hash from aktivacia where id='".$_SESSION['user_id']."';";
$conn = connect();
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$conn->close();

sendVerificationEmail($_SESSION['user_login'],$row['hash'],$_SESSION['user_id']);
header("Location: app_aktivuj_email.php?status=ok");