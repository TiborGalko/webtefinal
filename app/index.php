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
			$_SESSION['user_type'] = getAccType($email)['role'];
			$_SESSION['user_id'] = getAccId($email)['id'];

			if(strcmp(getAccType($email)['role'], "admin") == 0){
				header("Location: app_admin.php");
			} else {
				header("Location: app_user.php");
			}

		} else {
			echo "neuspesne prihlasenie";
		}
	} 

	?>
