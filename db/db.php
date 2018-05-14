<?php
include_once "../config.php";

function connect()
{
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);
    if ($conn->connect_error) {
        die("Nepodarilo sa pripojit k databaze: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}