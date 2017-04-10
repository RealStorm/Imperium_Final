<?php 
	session_start();

	if(!isset($_SESSION['logged'])){
		header('Location: ../index.php');
		exit();
	}
	// vi kollar ifall någon har klickat på någon av knapparna och därefter bestämmer vad som händer.
    if (isset($_POST['hundradagar'])) {
        require_once('../php/conn.php');
        mysqli_report(MYSQLI_REPORT_STRICT);

        try{
        	$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
        	if($conn->connect_errno!=0) {
        		throw new Exeption(mysqli_connect_errno());
        	} else {
        		$currpremium = $conn->query("SELECT premium FROM users WHERE id='".$_SESSION['id']."'");
				if(!$currpremium) throw new Exception($conn->error);
				$result = mysqli_fetch_array($currpremium);

        		if($conn->query("UPDATE users SET premium = DATE_ADD(premium, INTERVAL 100 DAY) WHERE id ='".$_SESSION['id']."'")){
        			$_SESSION['premium'] = $result['premium'];
        			$_SESSION['fourteenDaysMessage'] = "<div class='fourteenDaysDiv'><div class='container'><span class='fourteenDaysSpan'>Grattis <br> Du köpte 100 dagar premium!</span><br><button class='backToGameButton'><a href='../gra.php'>Gå tillbaka spelet</a></button></div></div>";
        		}
        	}
        } catch (Expetion $e) {
        	echo '<span class="error">Server fel!</span>';
        }
    } else {
 		if(isset($_POST['sevenDays'])){
 			require_once('../php/conn.php');
 			mysqli_report(MYSQLI_REPORT_STRICT);

 			try{
        	$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
        	if($conn->connect_errno!=0) {
        		throw new Exeption(mysqli_connect_errno());
        	} else {
        		$currpremium = $conn->query("SELECT premium FROM users WHERE id='".$_SESSION['id']."'");
				if(!$currpremium) throw new Exception($conn->error);
				$result = mysqli_fetch_array($currpremium);

        		if($conn->query("UPDATE users SET premium = DATE_ADD(premium, INTERVAL 7 DAY) WHERE id ='".$_SESSION['id']."'")){
        			$_SESSION['premium'] = $result['premium'];
        			$_SESSION['fourteenDaysMessage'] = "<div class='fourteenDaysDiv'><div class='container'><span class='fourteenDaysSpan'>Grattis <br> Du köpte 7 dagar premium!</span><br><button class='backToGameButton'><a href='../gra.php'>Gå tillbaka spelet</a></button></div></div>";
        		}
        	}
        } catch (Expetion $e) {
        	echo '<span class="error">Server fel!</span>';
        }
 			
 		} else {
 			if(isset($_POST['fourteenDays'])){
				require_once('../php/conn.php');
 				mysqli_report(MYSQLI_REPORT_STRICT);

	 			try{
	        	$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
	        	if($conn->connect_errno!=0) {
	        		throw new Exeption(mysqli_connect_errno());
	        	} else {
	        		$currpremium = $conn->query("SELECT premium FROM users WHERE id='".$_SESSION['id']."'");
					if(!$currpremium) throw new Exception($conn->error);
					$result = mysqli_fetch_array($currpremium);

	        		if($conn->query("UPDATE users SET premium = DATE_ADD(premium, INTERVAL 14 DAY) WHERE id ='".$_SESSION['id']."'")){
	        			$_SESSION['premium'] = $result['premium'];
	        			$_SESSION['fourteenDaysMessage'] = "<div class='fourteenDaysDiv'><div class='container'><span class='fourteenDaysSpan'>Grattis <br> Du köpte 14 dagar premium!</span><br><button class='backToGameButton'><a href='../gra.php'>Gå tillbaka spelet</a></button></div></div>";
	        		}
	        	}
	        } catch (Expetion $e) {
	        	echo '<span class="error">Server fel!</span>';
	        }
 			} else {
 				if(isset($_POST['thirtyDays'])){
					require_once('../php/conn.php');
 					mysqli_report(MYSQLI_REPORT_STRICT);

		 			try{
		        	$conn = new mysqli($host, $dbuser, $dbpassword, $dbname);
		        	if($conn->connect_errno!=0) {
		        		throw new Exeption(mysqli_connect_errno());
		        	} else {
		        		$currpremium = $conn->query("SELECT premium FROM users WHERE id='".$_SESSION['id']."'");
						if(!$currpremium) throw new Exception($conn->error);
						$result = mysqli_fetch_array($currpremium);

		        		if($conn->query("UPDATE users SET premium = DATE_ADD(premium, INTERVAL 30 DAY) WHERE id ='".$_SESSION['id']."'")){
		        			$_SESSION['premium'] = $result['premium'];
		        			$_SESSION['fourteenDaysMessage'] = "<div class='fourteenDaysDiv'><div class='container'><span class='fourteenDaysSpan'>Grattis <br> Du köpte 30 dagar premium!</span><br><button class='backToGameButton'><a href='../gra.php'>Gå tillbaka spelet</a></button></div></div>";
		        		}
		        	}
		        } catch (Expetion $e) {
		        	echo '<span class="error">Server fel!</span>';
		        }

 				}
 			}
 		}
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Köp Premium</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="../styles/kopstyle.css" rel="stylesheet">
    <link href="../styles/spelstyle.css" rel="stylesheet">
    <script src="../js/fontawesome.js"></script>
</head>

<body>
<div class="show">
	<?php if(isset($_SESSION['fourteenDaysMessage'])) { echo $_SESSION['fourteenDaysMessage']; unset($_SESSION['fourteenDaysMessage']);} ?>
</div>
	<header>
		<nav>
			<ul>
				<li><a class="welcomeUser" href="../sites/profile.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo $_SESSION['user'];?></a></li>
				<li><a class="logOut" href="php/wyloguj.php">Logga ut<i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
			</ul>
		</nav>
	</header>
	<main>
		<div class="stockDiv">
		<div class="first">
		<form action="" method="POST" class="restDays">
			<img class="premiumIcon" src="../img/premium.png" alt="premium_icon">
			<br>
			<button name="sevenDays" class="buttonBuyPremium">Köp 7 Dagar</button>
			<br>
			<label for="buttonBuyPremium">50 SEK</label>
			</form>
		</div>
		<div class="second">
			<form action="" method="POST" class="restDays">
			<img class="premiumIcon" src="../img/premium.png" alt="premium_icon">
			<br>
			<button name="fourteenDays" class="buttonBuyPremium">Köp 14 Dagar</button>
			<br>
			</form>
			<label for="buttonBuyPremium">75 SEK</label>
		</div>
		<div class="last">
			<form action="" method="POST" class="restDays">
			<img class="premiumIcon" src="../img/premium.png" alt="premium_icon">
			<br>
			<button name="thirtyDays" class="buttonBuyPremium">Köp 30 Dagar</button>
			<br>
			</form>
			<label for="buttonBuyPremium">100 SEK</label>
		</div>
		</form>
		</div>
		<div class="saleDiv">
			<form class="hundradgar" action="" method="POST">
			<img class="premiumIcon" src="../img/premium_salte.png" alt="sale_icon">
			<br>
			<br>
			<button name="hundradagar" class="buttonBuyPremium">Köp 100 dagar</button>
			<br>
			<br>	
			<label for="buttonBuyPremium" class="premiumSaleSec">250 SEK</label>
			<br>
			<label for="buttonBuyPremium" class="premiumSale">Få 40% på priset!</label>
		</div>
	</main>
	<footer>
		<p class="footerText">Copyright 2017 © Patryk Rybaczek</p>
	</footer>
</body>

</html>