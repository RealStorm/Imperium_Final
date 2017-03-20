<?php  
	session_start();

	if(isset($_POST['email'])) {
		//Variabeln validation sätts till true
		$validation = true;

		//Validering av nick (användarnamnet)
		$nick = $_POST['nick'];

		//Vi kollar och bestämmer längden av variabeln
		if((strlen($nick)<3) || (strlen($nick)>20)) {
			$validation = false;
			$_SESSION['e_nick'] = "Användarnamnet måste innehålla från 3 till 20 tecken!";
			$_SESSION['error_input'] = 'class="input_error"';
		}

		//Validering av email
		//Vi kollar innehållet av variabeln email och sanitizerar den.
		$email = $_POST['email'];
		$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		//Forstätter kolla ifall emailen verkligen är en email dvs om den har rätt format.
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB != $email)) {
			$validation = false;
			$_SESSION['e_mail'] = "Emailen är i fel format!";
			$_SESSION['error_input'] = 'class="input_error"';
		}

		//Validering av lösenorden
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];

		//if satsen kollar längden på variabeln pass1 och pass2
		if((strlen($pass1)<8) || (strlen($pass2)<8)) {
			$validation = false;
			$_SESSION['e_pass'] = "Lösenordet måste bestå minst 8 tecken!";
			$_SESSION['error_input'] = 'class="input_error"';
		}

		//Undersöker ifall lösenorden inte är samma.
		if($pass1 != $pass2) {
			$validation = false;
			$_SESSION['e_pass'] = "Lösenorden måste matcha!";
			$_SESSION['error_input'] = 'class="input_error"';
		}
		//Vi hashar lösenordet för extra säkerhet
		$pass_hash = sha1($pass1);

		//validering av checkboxen
		//Undersöker ifall checkboxen blev ibokad?
		if(!isset($_POST['regulamin'])) {
			$validation = false;
			$_SESSION['e_regulamin'] = "Akceptera villkoren!";
			$_SESSION['error_input'] = 'class="input_error"';
		}

		//Validering av google bot
		//Repatcha bot or not hehe
		$secret = "6LfIsRYUAAAAAJ4IiJJzG4UJAhTi6y-qpCQB9GaY";

		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST[
			'g-recaptcha-response']);

		$response = json_decode($check);

		if($response->success==false){
			$validation = false;
			$_SESSION['e_bot'] = "Bevisa att du är en människa!";
		}
		// Detta som händer här är att data som du matat in sparas så att ifall du missat ett tecken på ena lösenordet så kommer du inte behöva skriva om alla fälten.
		$_SESSION['form_nick'] = $nick;
		$_SESSION['form_email'] = $email;

		$_SESSION['form_pass1'] = $pass1;
		$_SESSION['form_pass2'] = $pass2;
		if(isset($_POST['regulamin'])) $_SESSION['form_regulamin'] = true;
		//Allting stämmer? Ja! Huraa haha vi förbereder allt och stoppar in värderna i våran databas.
		require_once "php/conn.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try{
			$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
			if($conn->connect_errno!=0) {
				throw new Exception(mysqli_connect_errno());
			}
			else{
				//Vi kollar om emailen finns redan så att flera använda inte kan ha samma email.
				$result = $conn->query("SELECT id FROM users WHERE email='$email'");

				if(!$result) throw new Exception($conn->error);

				$emailrecord = $result->num_rows;
				if($emailrecord>0) {
					$validation = false;
					$_SESSION['e_mail'] = "Emailen är redan registrerad!";
					$_SESSION['error_input'] = 'class="input_error"';
				}
				//Samma sak som högre upp fast med vårt användarnamn helt enkelt.
				$result = $conn->query("SELECT id FROM users WHERE user='$nick'");

				if(!$result) throw new Exception($conn->error);
				$nickrecord = $result->num_rows;

				if($nickrecord>0) {
					$validation = false;
					$_SESSION['e_nick'] = "Användarnamnet är upptaget!";
					$_SESSION['error_input'] = 'class="input_error"';
				}

				if($validation == true) {
					//Validationen är TRUE HURAAA nu händer det grejer påriktigt! vi sätter in våran nya användare i databasen dessutom ger honom 14 dagar gratis premium och 100 utan alla resorces så att han kan börja bygga sin koloni.
					if($conn->query("INSERT INTO users VALUES(NULL,'$nick','$pass_hash','$email', 100, 100, 100, 100, now() + INTERVAL 14 DAY)"))
					{
						$_SESSION['successreg']="true";
						unset($_SESSION['error_input']);
						header('Location: sites/witamy.php');
					}
					else
					{
						throw new Exception($conn->error);
					}

				}	

				$conn->close();
			}
		}
		catch(Exception $e){
			echo '<span class="error">Server fel!</span>';
			//echo '<br> Dev information helt enkelt..'.$e;
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Osadnicy zaloz darmowe konto</title>
    <link href="styles/regstyle.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <script src="js/fontawesome.js"></script>
</head>

<body>
	<form class="regForm" method="post">
		<label for="username">Nickname</label>
		<i class="fa fa-user" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="text" id="firstInput" value="<?php if(isset($_SESSION['form_nick'])){
			echo $_SESSION['form_nick'];
			unset($_SESSION['form_nick']);
			} ?>" name="nick" placeholder="Användarnamn"><br>
		<?php  
			if(isset($_SESSION['e_nick'])) {
				echo '<p class="error">'.$_SESSION['e_nick'].'</p>';
				unset($_SESSION['e_nick']);
			}
		?>
		<br>
		<label for="email">Email</label>
		<i class="fa fa-envelope" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="text" value="<?php if(isset($_SESSION['form_email'])){
			echo $_SESSION['form_email'];
			unset($_SESSION['form_email']);
			} ?>"  name="email" placeholder="Email"><br>
		<?php  
			if(isset($_SESSION['e_mail'])) {
				echo '<p class="error">'.$_SESSION['e_mail'].'<p>';	
				unset($_SESSION['e_mail']);		
			}
		?>
		<br>
		<label for="pass1">Password</label>
		<i class="fa fa-key" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="password" value="<?php if(isset($_SESSION['form_pass1'])){
			echo $_SESSION['form_pass1'];
			unset($_SESSION['form_pass1']);
			} ?>"  name="pass1" placeholder="Lösenord"><br><br>
		<label for="pass2">Rep Password</label>
		<i class="fa fa-key" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="password" value="<?php if(isset($_SESSION['form_pass2'])){
			echo $_SESSION['form_pass2'];
			unset($_SESSION['form_pass2']);
			} ?>"  name="pass2" placeholder="Bekräfta lösenord">
		<?php  
			if(isset($_SESSION['e_pass'])) {
				echo '<p class="error">'.$_SESSION['e_pass'].'</p>';
				unset($_SESSION['e_pass']);
			}
		?>
		<label class="checkBox">
		<br>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="checkbox" name="regulamin" <?php 
			if(isset($_SESSION['form_regulamin'])){
				echo "checked";
				unset($_SESSION['form_regulamin']);
			}
		?>/> Jag godkänner villkoren<br>
		</label>
		<?php  
			if(isset($_SESSION['e_regulamin'])) {
				echo '<p class="error">'.$_SESSION['e_regulamin'].'</p>';
				unset($_SESSION['e_regulamin']);
			}
		?>
		<br>
		<div class="g-recaptcha" data-sitekey="6LfIsRYUAAAAAMa_mWG2WC9yT4ppnugVIl1t2w8k"></div>
		<?php  
			if(isset($_SESSION['e_bot'])) {
				echo '<p class="error">'.$_SESSION['e_bot'].'</p>';
				unset($_SESSION['e_bot']);
			}
		?>
		<br>
		<input type="submit" value="Skapa konto">
		<p class="logP">Har du redan ett konto?</p>
		<div class="logHyper">
		<a href="index.php">Logga in här!</a>
		</div>
	</form>
</body>

</html>