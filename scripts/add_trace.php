	<?php

	include_once "../db/usersdb.php";

	session_start();
	$user_id = $_SESSION['user_id'];
	$from = $_POST['postfrom'];
	$to = $_POST['postto'];

	insertIntoTraces($user_id, $from, $to);

	?>