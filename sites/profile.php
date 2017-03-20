<?php 
	session_start();

	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}

	if(isset($_POST['currpass'])){
		//Sätter validations variablen till true, ifall vi begår något fel i validationen kommer variablen då bli false och inget kommer skickas till db.
		$validation = true;

		//VALIDERING AV LÖSENORD
		$currpass = $_POST['currpass'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		// Med strlen String length kollar vi längden på våra inmatade lösenord
		if((strlen($currpass)<8) || (strlen($pass1)<8) || (strlen($pass2)<8)){
			$validation = false;
			echo "Lösenorden måste minst vara 8 tecken!";
		}
		// != kollar om lösenorden är olika ifall dom är det blir det lite knasigt då dom ska vara samma!!!!!
		if($pass1 != $pass2){
			$validation = false;
			echo "Lösenorden måste vara likadana!";
		} 

		//Här ska vi öppna en koppling till dbasen och kolla ifall det så kallade CURRPASS dvs aktuella lösenord stämmer med det du matade in i inputen.
		require_once "../conn.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try{
			$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
			if($conn->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
				// vi tar ut lösenordet där id i databasen är samma som sessions id dvs inloggade användaren.
				$resultat = $conn->query("SELECT pass FROM users WHERE id='".$_SESSION['id']."'");
				// vi sätter in svaret i variabeln dbrecord.
				$dbrecord = $resultat->fetch_assoc();
				// med if statment kollar vi om våran currpass stämmer med våran "currpass" i databasen.
				if(sha1($currpass) == $dbrecord['pass']) {
					echo "super super dunder funkar";
					$nyapass = $conn->query("UPDATE users SET pass ='".sha1($pass1)."' WHERE id ='".$_SESSION['id']."'");
				}
				else {
					$_SESSION['error_']
				}

			}
		}catch(Exception $e){
			echo '<span class="error">Server fel!</span>';
			//echo '<br> Dev information helt enkelt..'.$e;
		}





		// Fint valideringen lyckades nu kan vi ändra ditt dåliga lösenord!
		if($validation == true) {
			echo "Validering lyckades ditt lösen kommer nu ändras bitch!";
		}


	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Imperium</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="../styles/spelstyle.css" rel="stylesheet">
    <link href="../styles/profilestyle.css" rel="stylesheet">
    <script src="../script/fontawesome.js"></script>
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a class="welcomeUser" href="#"><?php echo $_SESSION['user'];?></a></li>
				<li><a href="#"><?php echo "Sten: ".$_SESSION['kamien'];?></a></li>
				<li><a href="#"><?php echo "Vete: ".$_SESSION['zboze']; ?></a></li>
				<li><a href="#"><?php echo "Guld: ".$_SESSION['zloto'];?></a></li>
				<li><a href="#"><?php echo "Trä: ".$_SESSION['drewno'];?></a></li>
				<li><a class="logOut" href="../wyloguj.php">Logga ut</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<div class="profileBox">
			<div class="profileAbout">
				<h2 class="profileUsername"><?php echo $_SESSION['user'];?></h2>
			 	<?php echo '<p class="profileEmail">Email: '.$_SESSION['email'].'</p>';?>
			 </div>	
			<form action="" method="POST" class="profileChange">
				<label for="currpassword"></label>
				<i class="fa fa-key" aria-hidden="true"></i>
				<input type="password" name="currpass" placeholder="Nuvarande Lösenord">
				<br><br>
				<label for="password1"></label>
				<i class="fa fa-key" aria-hidden="true"></i>
				<input type="password" name="pass1" placeholder="Ditt nya Lösenord">
				<br><br>
				<label for="password2"></label>
				<i class="fa fa-key" aria-hidden="true"></i>
				<input type="password" name="pass2" placeholder="Bekräfta Lösenord">
				<br><br>
				<input type="submit" name="submit" value="Spara">
				<p class="premium"><?php echo "Premium tar slut: ".$_SESSION['premium'];?></p>
			</form>
		</div>	
		<button class="buttonGame" onclick="window.location.href='../gra.php'">Gå tillbaka till spelet</button>
		<button class="buttonBuyPremium">Köp mer premium!</button>
	</main>

	<footer>
		<p class="footerText">Copyright 2017 © Patryk Rybaczek</p>
	</footer>

</body>

</html>