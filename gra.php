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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Imperium</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="styles/spelstyle.css" rel="stylesheet">
    <link href="styles/fakegame.css" rel="stylesheet" >
    <script src="js/fontawesome.js"></script>
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a class="welcomeUser" href="sites/profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo $_SESSION['user'];?></a></li>
				<li><a class="logOut" href="php/wyloguj.php">Logga ut<i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
			</ul>
		</nav>
	</header>

	<main>
		<div class="mainBox">
			<?php echo '<p class="mainBoxWelcomeText">Välkommen '.$_SESSION['user'].'</p>';?>
			<div class="sidebar">
				<div class="resources">
					<h2 class="head">Resurser</h2>
					<?php echo "<span class='DisplayZloto'>Guld: ".$_SESSION['zloto']."</span><br>"?>		
					<?php echo "<span class='DisplayKamien'>Sten: ".$_SESSION['kamien']."</span><br>"?>
					<?php echo "<span class='DisplayDrewno'>Trä: ".$_SESSION['drewno']."</span><br>"?>
					<?php echo "<span class='DisplayZboze'>Vete: ".$_SESSION['zboze']."</span><br>"?>
				</div>
			</div>
		</div>
	</main>

	<footer>
		<p class="footerText">Copyright 2017 © Patryk Rybaczek</p>
	</footer>
</body>

</html>