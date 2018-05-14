<!DOCTYPE html>
<html>
<head>
	<title></title>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="news-script.js"></script>

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>

    <span id="news-back">Spat</span><br>

	<?php

	include "../config.php";

	$id = $_POST['postid'];

	// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM news WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<b>".$row["title"]."</b><br>".$row["id_autor"]."<br>".$row["text"]."<br>".$row["created"];
        }
    } else {
        echo "Novinka sa nenasla";
    }

    $conn->close();

	?>

</body>
</html>