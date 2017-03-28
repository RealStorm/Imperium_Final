<?php 

	session_start();

	if((!isset($_POST['username'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();
	}

	require_once "conn.php";

	$conn = @new mysqli($host, $dbuser, $dbpassword, $dbname);

	if($conn->connect_errno!=0) {
		echo "Error".$conn->connect_errno;
	}
	else {

		$username = $_POST['username'];
		$password = $_POST['password'];	

		$username == htmlentities($username, ENT_QUOTES, "UTF-8");

		if ($result = @$conn->query(
			sprintf("SELECT * FROM users WHERE user='%s'",
			mysqli_real_escape_string($conn,$username)))) {

			$user_number = $result->num_rows;

			if ($user_number>0) {
				$dbrecord = $result->fetch_assoc();

				if(sha1($password) == $dbrecord['pass']) {

					$_SESSION['logged'] = true;
					$_SESSION['id'] = $dbrecord['id'];
					$_SESSION['user'] = $dbrecord['user'];
					$_SESSION['email'] = $dbrecord['email'];

					$_SESSION['drewno'] = $dbrecord['drewno'];
					$_SESSION['kamien'] = $dbrecord['kamien'];
					$_SESSION['zboze'] = $dbrecord['zboze'];
					$_SESSION['zloto'] = $dbrecord['zloto'];

					$_SESSION['premium'] = $dbrecord['premium'];

					unset($_SESSION['error']);
					$result->free_result();
					header('Location: ../gra.php');
				}else{
					$_SESSION['error'] = '<span class="error">Användaren hittades ej</span>';
					header('Location: index.php');
				}				
			}
			else{
				$_SESSION['error'] = '<span class="error">Användaren hittades ej</span>';
				$_SESSION['error_input'] = 'class="input_error"';
				header('Location: ../index.php');
			}
		} 
		$conn->close();
	}




 ?>