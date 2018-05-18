	<?php

	include_once "../db/usersdb.php";
	include_once "../db/db.php";		
	session_start();
	$email = $_POST['email'];
	$pwd = $_POST['password'];

	if($pwd == 'user123'){
		$_SESSION['user_login'] = $email;
		header("Location: change_password.php");
	}else{

	if(isset($email) && isset($pwd)){
		if(checkPasswd($email,$pwd)){		
			//echo "uspesne prihlasenie";
			
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
                        echo "<script>alert('Prihlásenie úspešné'); window.location.href = 'app_aktivuj_email.php'; </script>";
						//header("Location: app_aktivuj_email.php");
					}else{
                        echo "<script>alert('Prihlásenie úspešné'); window.location.href = 'app_user.php'; </script>";
						//header("Location: ");
	    			}
	    		}
			}
		} else {
			echo "<script>alert('Neuspesne prihlásenie'); window.location.href = '../user/prihlasenie.html'; </script>";

            //header("Location: ../index.php");
		}
	} 
}

	?>
