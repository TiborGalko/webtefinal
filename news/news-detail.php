<!DOCTYPE html>
<html lang="en">
<head>
	<title>Detail aktuality</title>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="news-script.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>

    <header class="jumbotron">
        <h1>Detail aktuality</h1>
        <span id="news-back">Spat</span><br>
    </header>

    <div class="container">    

	<?php

	include_once "../db/db.php";

	$id = $_POST['postid'];

	// Create connection
    $conn = connect();

    $sql = "SELECT * FROM news WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<b>".$row["title"]."</b><br><span class='autor'>".$row["autor"]."</span><br>".$row["text"]."<br><i>".$row["created"]."</i>";
        }
    } else {
        echo "Novinka sa nenasla";
    }

    $conn->close();

	?>
</div>
</body>
</html>