<?php
	require_once("../db/UserDbUtil.php");

	session_start();
?>
<?php
		$id="";
		if(isset($_SESSION["username"])){
			$id=$_SESSION["username"];
			$dbutil=new UserDbUtil();
			$user=$dbutil->findUserByUsername($id);
		}
		else{
			header("Location: login_form.php");
		}
		include("header.php");
		$categorije=$dbutil->getCategoryByUser($id);
	?>
	<center>
		<img src="../slike/profilslika.jpg" height="70"  width="70">
	</center>
		<fieldset><legend>Basic Informations</legend>
		<?php
			echo"
			FirstName:".$user["first_name"]."<br>
			LastName:".$user["last_name"]. "<br>
			Gender:".$user["gender"]. "<br>
			Birthday:".$user["birthday"]."<br>
			City:".$user["city"]."<br>
			School:".$user["school"];
		?>
		</fieldset>
	<fieldset><legend>Account details</legend>
		<?php
		echo "
			<br>Username:".$user["username"]."<br>
			Password:".$user["password"]."<br>";
		?>
	</fieldset>
		<fieldset>
			<legend>Things you like</legend>
		Vasi omiljeni citati:
		<?php
			$file=fopen("../db/files/$_SESSION[username]/citati.txt","r");
			while(feof($file)){
				echo fgets($file)."<br>";
			}
			echo "<br>";
			echo "Vasa interesovanja:";
			foreach ($categorije as $hobi) {
					echo $hobi["name"];
					}
		?>
		</fieldset>
		<form action="promenaInformacija.php" method="post">
			<input type="submit" name="submit"value="promenite vase informacije!">
			<!--<input type="hidden" name="username" value=" <?php echo $id ?> "> -->
		</form>
</body>
</html>
