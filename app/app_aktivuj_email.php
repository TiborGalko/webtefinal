<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<div>
		<?php
		//nove odoslanie aktivacneho mailu
		if(isset($_GET['status'])){
			echo 'email bol odoslany';	
		}else{
		echo "prosim aktivujte si ucet kliknutim na link ktory vam prisiel emailom".PHP_EOL;
		}
		?>
		<form action="preposli_mail.php" method="post">
			<input type="submit" name="posli" value="posli mail znovu">
		</form>
		</div>
</body>
</html>