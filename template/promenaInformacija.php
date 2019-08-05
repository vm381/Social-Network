<?php 
		require_once("../db/UserDbUtil.php");
		require_once("../classes/User.php");
		require_once("../db/PageDbUtil.php");
		session_start();
		$id="";
		$categorije="";
		if(isset($_SESSION["username"])){
			$id=$_SESSION["username"];
			$dbutil=new UserDbUtil();
			$pdbutil=new PageDbUtil();
			$user=$dbutil->findUserByUsername($id);
			$categorije=$pdbutil->getCategory();

		}
		else{
			header("Location: informacije.php");
		}
		if(isset($_POST["submit"])){
			if(isset($_POST["ime"])){
				if($_POST["ime"]!=""){
					$dbutil->updateName(htmlspecialchars($_POST["ime"]),$id);
					echo "<br>";
				}//updte u bazi
			}
			if(isset($_POST["prezime"])){
				if($_POST["prezime"]!=""){
					$dbutil->updateLastName(htmlspecialchars($_POST["prezime"]),$id);
					echo "<br>";
				}		//update u bazi
			}
			if(isset($_POST["citat"])){
				if($_POST["citat"]){
					if(file_exists("../db/files/$id/citati.txt")){
						$myFile=fopen("../db/files/$id/citati.txt", "a") or die("Unable to open file!");
						fwrite($myFile, $_Post["citat"]);
					}
				}
			}
		}
		include("header.php");
	?>

	<center>
		<fieldset>
			<legend> Promenite vase infromacije!</legend>
			<form method="post">
				Unesite vase ime:
				<input type="text" name="ime">
				<br><br>
				Promenite vase prezime:
				<input type="text" name="prezime">
				<br><br>
				Promenite vasu lozinku:
				<input type="text" name="">
				<br><br>
				Ubacite novi citat:
				<input type="text" name="citat">
				<br><br>
				Izaberite hobi:
				<select name="category">
				<?php 
					foreach ($categorije as $value) {
						echo "<option value=\"{$value->getId()}\">{$value->getName()}</option>";
					}
				?>
			</select>
				<br><br>
				Promenite sliku:
				<input type="file" name="file">
				<br><br>
				Dodajte novi citat:
				<input type="text" name="citat">
				<br><br>
				<input type="submit" name="submit">
			</form>
		</fieldset>
	</center>
<?php
	include("footer.php");
?>