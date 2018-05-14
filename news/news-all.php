<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
	<script src="news-script-all.js"></script>
    <script src="../libs/jquery.redirect-master/jquery.redirect.js"></script>

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>

    <a href="../index.php">Domov</a><br>

	<?php

	include "../config.php";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM news ORDER BY created DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $text = $row["text"];

            if(strlen($text) > 150){
                $text = substr($text, 0, 150);
                $text .= "...";
            }
            echo "<b>".$row["title"]."</b><br>".$text."<span id=".$row["id"]." class='news-clickable'> citaj dalej</span><br>".$row["id_autor"]."<br>".$row["created"]."<br>--------------------------------<br>";
        }
    } else {
        echo "Ziadne novinky";
    }

    $conn->close();

	?>

</body>
</html>