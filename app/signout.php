<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php

	session_start();
	session_unset();
	session_destroy();

	?>

	Uspesne odhlasenie<br>
	<a href="../index.php">Domov</a>
</body>
</html>