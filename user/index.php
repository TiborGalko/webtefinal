<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Aplikácia</title>
	<script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <!-- news script -->
    <script src="../news/news-script.js"></script>
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
    <h1>Aplikácia</h1>
</header>
<div class="container">
	<?php

	include_once "../db/usersdb.php";
	include_once "../db/db.php";		

	$email = $_POST['email'];
	$pwd = $_POST['password'];

	if(isset($email) && isset($pwd)){
		if(checkPasswd($email,$pwd)){		
			echo "uspesne prihlasenie";	
			session_start();
			$_SESSION['user_login'] = $email;

		} else {
			echo "neuspesne prihlasenie";
		}
	} else {
		session_start();
	}

	// ZOBRAZOVANIE AKTUALIT
	if(isset($_SESSION['user_login'])){

		echo "<h2>Aktuality</h2>";		

    	// Create connection
		$conn = connect();
		$sql = "SELECT * FROM news ORDER BY created DESC LIMIT 3";
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
			echo "<a href='../news/news-all.php'>Zobrazit vsetky novinky</a>";
		} else {
			echo "Ziadne novinky";
		}

		$conn->close();
	}

	?>
</div>
</body>
</html>