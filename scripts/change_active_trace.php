<?php

	include_once "../db/db.php";

	$from = $_POST['postfrom'];
	$to = $_POST['postto'];
	session_start();
	$user_id = $_SESSION['user_id'];

	$conn = connect();
	$sql = "SELECT * FROM traces WHERE from_t='$from' AND to_t='$to' AND (id_autor='$user_id' OR mode='verejny')";

	$result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $trace_id = $row['id'];

    $sql = "UPDATE users SET active_trace='$trace_id' WHERE id='$user_id'";
    $conn->query($sql);

    $conn->close();
?>