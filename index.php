<?php 
	session_start();	

	if((isset($_SESSION['logged']) && ($_SESSION['logged']== true))) {
		header('Location: gra.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Välkommen till Imperium</title>
    <link href="styles/indexstyle.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <script src="js/fontawesome.js"></script>
</head>

<body>
	<form class="logForm" action="php/zaloguj.php" method="post">
		<h1 class="logWelcome">Välkommen</h1>
		<p class="logfras">Börja spela redan idag!</p>
		<label for="login">Login</label>
		<i class="fa fa-user" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="text" name="username" placeholder="Användarnamn" required>
			<br><br>
		<label for="pass">Haslo</label>
		<i class="fa fa-key" aria-hidden="true"></i>
		<input <?php if(isset($_SESSION['error_input'])){ echo $_SESSION['error_input'];} ?> type="password" name="password" placeholder="Lösenord" required>
			<br><br>
		<input type="submit" value="Logga in">
			<br>
		<?php 
			if (isset($_SESSION['error'])) {
				echo $_SESSION['error'];
			}		
		?>
		<p class="regP">Har du inget konto?</p>
		<div class="regHyper">
		<a href="rejestracja.php">Skapa ditt konto idag!</a>
		</div>
	</form>
</body>

</html>