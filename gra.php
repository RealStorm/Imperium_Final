<?php 
	
	session_start();

	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		exit();
	}

	//echo "<p><b>Witaj:</b> ".$_SESSION['user'].', <a href="wyloguj.php">[Wyloguj]</a></p>';
	//echo "<p><b>Drewno:</b> ".$_SESSION['drewno'];
	//echo "｜<b>Kamien:</b> ".$_SESSION['kamien'];
	//echo "｜<b>Zboze:</b> ".$_SESSION['zboze'];
	//echo "｜<b>Zloto:</b> ".$_SESSION['zloto']."</p>";

	//echo "<p><b>Email:</b> ".$_SESSION['email']."</p>";
	//echo "<p><b>Data wygasniecia premium:</b> ".$_SESSION['premium']." Dni Premium</p>";

	$dataczas = new DateTime();

	echo "data i czas serwera: ".$dataczas->format('Y-m-d H:i:s')."<br>";

	$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['premium']);

	$roznica = $dataczas->diff($koniec);

	if($dataczas<$koniec) {
		echo "Pozostalo premium: ".$roznica->format('%y lat, %m mies, %d dni, %h godzin, %i minuty, %s sek');
	}
	else {
		echo "Premium nie aktywne od: ".$roznica->format('%y lat, %m mies, %d dni, %h godzin, %i minuty, %s sek');
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Imperium</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="styles/spelstyle.css" rel="stylesheet">
    <script src="script/fontawesome.js"></script>
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a class="welcomeUser" href="sites/profile.php"><?php echo $_SESSION['user'];?></a></li>
				<li><a href="#"><?php echo "Sten: ".$_SESSION['kamien'];?></a></li>
				<li><a href="#"><?php echo "Vete: ".$_SESSION['zboze']; ?></a></li>
				<li><a href="#"><?php echo "Guld: ".$_SESSION['zloto'];?></a></li>
				<li><a href="#"><?php echo "Trä: ".$_SESSION['drewno'];?></a></li>
				<li><a class="logOut" href="php/wyloguj.php">Logga ut</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<div class="mainBox">
			<?php echo '<p class="mainBoxWelcomeText">Välkommen '.$_SESSION['user'].'</p>';?>
			<p class="mainBoxText">Tyvärr</p>
			<p class="mainBoxTextUnder">Just nu går det inte att spela Imperium då spelet är under konstruktion</p>
		</div>
	</main>

	<footer>
		<p class="footerText">Copyright 2017 © Patryk Rybaczek</p>
	</footer>
</body>

</html>