<?php

	require_once("../classes/Login.php");

	$ok = true;

	if(isset($_POST["login"])) {
		$lg = new Login();
		$ok = $lg->signin(htmlspecialchars($_POST["username"]), htmlspecialchars($_POST["password"]));
		if($ok) {
			session_start();
			$_SESSION["username"] = htmlspecialchars($_POST["username"]);
			header("Location: pocetna.php");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Welcome </title>
</head>
<body>

	<?php
		if(!$ok) {
			echo "<h3> Something went wrong. </h3>";
		}
	?>

	<form action="login_form.php" method="post">
		Username: <br> <input type="text" name="username"> <br>
		Password: <br> <input type="password" name="password"> <br>

		<input type="submit" name="login" value="Sign in">
	</form>
	<br>
	<a href="registration_form.php"><button>Sign up</button></a>
</body>
</html>
