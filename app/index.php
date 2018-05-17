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
				$sql = "select active from aktivacia where id='".$_SESSION['user_id']."';";
				$conn = connect();
				$result = $conn->query($sql);
				$conn->close();
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					if($row['active']==0){
						header("Location: app_aktivuj_email.php");
					}else{
						header("Location: app_user.php");
	    			}
				
	    		}
			}

		} else {
			echo "neuspesne prihlasenie";
		}
	} 

	?>
