<!DOCTYPE html>
<html lang="en">
<head>
	<title>Vsetky aktuality</title>
	<script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
	<script src="news-script-all.js"></script>
    <script src="../libs/jquery.redirect-master/jquery.redirect.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <header class="jumbotron">
        <h1>Vsetky aktuality</h1>
        <a href="javascript:history.back()">Spat</a><br>
    </header>

    <div class="container">
    

	<?php

	include_once "../db/db.php";

    // Create connection
    $conn = connect();

    $sql = "SELECT * FROM news ORDER BY created DESC ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $text = $row["text"];

            if(strlen($text) > 150){
                $text = substr($text, 0, 150);
                $text .= "...";
            }
            echo "<b>".$row["title"]."</b><br>".$text."<span id=".$row["id"]." class='news-clickable'> citaj dalej</span><br><span class='autor'>".$row["autor"]."</span><br><i>".$row["created"]."</i><br><hr>";
        }
    } else {
        echo "Ziadne novinky";
    }

    $conn->close();

	?>
</div>
</body>
</html>