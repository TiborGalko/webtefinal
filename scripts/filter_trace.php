<?php

	include_once "../db/usersdb.php";

	$text = $_POST['posttext'];

	getFilterTraces($text);

?>