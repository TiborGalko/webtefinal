<?php

	include_once "../db/usersdb.php";

	$title = $_POST['title'];
	$text = $_POST['news_text'];
	session_start();
	$user_name = $_SESSION['user_id'];

	insertIntoNews($title, $text);
	//echo $user_name.$title.$text;
	sendNews($title, $text);
	header("Location: ../news/news-add.php?status=ok");
?>