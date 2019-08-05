<?php
	$name=$_SESSION['username'];
	$file=fopen(".../$name/quiz.txt", "r");
	$user=array();
	$arraydat=array();
	$array=array();
	while ($line = fgets($file)) {
	
			$array=explode("\n", $line);
        	
	}
	
	fclose($file);
?>
<!DOCTYPE html>

<html>
<head>
	<title></title>
</head>
<body>
	
		<div id="container">
			<?php
		for ($i=0; $i <sizeof($array); $i++) { 
			# code...
		    echo '<div class="row">
		       	<div class="name">';
		       	$array[$i].'</div>
		   	</div>';
		}

	?>
	</div>
	<form action="quiz.php" method="post">
		<a href="quiz.php"><input type="submit" name="quiz" value="quiz"></a>
	</form>
		<form action="history.php" method="post">
		<a href="history.php"><input type="submit" name="history" value="history"></a>
	</form>
	<form action="profil.php" method="post">
		<a href="profil.php"><input type="submit" name="profil" value="profil"></a>
	</form>
	<form action="leaderboard.php" method="post">
		<a href="leaderboard.php"><input type="submit" name="global" value="global"></a>
		</form>
</body>
</html>