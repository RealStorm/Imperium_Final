<?php 
	session_start();	

	if((!isset($_SESSION['successreg']))) {
		header('Location: index.php');
		exit();
	}
	else {
		unset($_SESSION['successreg']);
	}

	// usuwamy zmienne pamietajace wartosci wpisane w formie
	if(isset($_SESSION['form_nick'])) unset($_SESSION['form_nick']);
	if(isset($_SESSION['form_email'])) unset($_SESSION['form_email']);
	if(isset($_SESSION['form_pass1'])) unset($_SESSION['form_pass1']);
	if(isset($_SESSION['form_pass2'])) unset($_SESSION['form_pass2']);
	if(isset($_SESSION['form_regulamin'])) unset($_SESSION['form_regulamin']);

	// usuwanie bledow rejestracij
	if(isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if(isset($_SESSION['e_mail'])) unset($_SESSION['e_mail']);
	if(isset($_SESSION['e_pass1'])) unset($_SESSION['e_pass1']);
	if(isset($_SESSION['e_pass2'])) unset($_SESSION['e_pass2']);
	if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Osadnicy gra-przegladarkowa</title>
    <link href="styles/welcomestyle.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
</head>

<body>
<div class="welcomeDiv">
	<h1 class="welcomeH">Välkommen!</h1>
	<p class="welcomeP">Ditt konto har nu skapats!</p>
	<p class="welcomePA">Här kan du<a href="index.php"> logga in</a></p>
</div>
</body>

</html>