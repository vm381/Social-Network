<?php 
	require_once('../classes/Category.php');
	require_once('../db/PredlaganjeUtil.php');
	include("header.php");
	include("footer.php");

	session_start();
	$user = '';
	if (!isset($_SESSION["username"])) {
    	header("Location: login_form.php");
  	}
	else {
		$user = $_SESSION["username"];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Predlaganje</title>
</head>
<body>
	<?php 
		// SKRIPTA UZIMA USERNAME IZ SESIJE

		$datebase = new Predlaganje();

		echo "$user";

		$prijatelji = $datebase->predlogPrijatelja($user);
		echo "OSOBE KOJE MOZDA POZNAJETE? <br>";
		foreach ($prijatelji as $obj) {
			echo $obj->getFirstName() . " " . $obj->getLastName() . "<br>";
		}

		$stranice = $datebase->predlogStranica($user);
		echo "<br> ZANIMLJIVE STRANICE! <br>";
		foreach ($stranice as $obj) {
			echo $obj->getNaziv() . " " . $obj->getOpis() . "<br>";
		}

		$grupe = $datebase->predlogGrupa($user);
		echo "<br> ZANIMLJIVE GRUPE! <br>";
		foreach ($grupe as $obj) {
			echo $obj->getNaziv(). "<br>";
		}

		$kor = $datebase->nadjiKorisnike("Name1", "Lastname1");
		echo "<br> NADJI OSOBE: <br>";
		foreach ($kor as $obj) {
			echo $obj->getFirstName() . " " . $obj->getLastName() . "<br>";
		}

		$str = $datebase->nadjiStranice("Stranica1");
		echo "<br> NADJI STRANICE! <br>";
		foreach ($str as $obj) {
			echo $obj->getNaziv() . " " . $obj->getOpis() . "<br>";
		}

		$grup = $datebase->nadjiGrupe("Grupa1");
		echo "<br> NADJI GRUPE! <br>";
		foreach ($grup as $obj) {
			echo $obj->getNaziv(). "<br>";
		}
	?>
</body>
</html>