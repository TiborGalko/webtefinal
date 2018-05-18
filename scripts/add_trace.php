	<?php

	include_once "../db/usersdb.php";

	session_start();
	$user_id = $_SESSION['user_id'];
	$from = $_POST['postfrom'];
	$to = $_POST['postto'];
	$user_type = $_SESSION['user_type'];

	if(strcmp($user_type, "user") == 0){
		$mode = "privatny";
	} else {
		$mode = "verejny";
	}

	insertIntoTraces($user_id, $from, $to, $mode);

	?>