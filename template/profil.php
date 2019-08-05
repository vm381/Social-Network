<?php
require_once("../db/UserDbUtil.php");
require_once("../classes/User.php");
require_once('../db/PredlaganjeUtil.php');

	
	session_start();

	$username1="";
	$dbutil=null;
	$user=null;
	$postDbUtil=new PostsDbUtil();
	if(isset($_GET["username1"])) {
		$username1=htmlspecialchars($_GET["username1"]);

		$dbutil=new UserDbUtil();
		$user=$dbutil->findUserByUsername($username1);



	}elseif (isset($_SESSION["username"])){
			$username=$_SESSION["username"];
			$dbutil=new UserDbUtil();
			$user=$dbutil->findUserByUsername($username);
	}
	else{
			header("Location: login_form.php");
		}
	if(isset($_POST["dodaj"])){
		$dbutil->dodajPrijatelja($username1,$username);

	}
	include("header.php");
	?>
	<center>
		<img src="../slike/profilslika.jpg" height="50"  width="50">
	</center>
	<?php
	$ime=$user["first_name"];
	$prezime=$user["last_name"];
	 echo "<center><h3>".$ime."  ".$prezime."</h3></center>";
	 //prikazuje se samo ako je moj profil
	 if(!strcmp($username1,"")){
	 	echo "
	 	<hr>
	 	<form name=\"informacije\" action=\"informacije.php\" method=\"post\">
	 		<input type=\"submit\" name=\"informacije\" value=\"Informacije\">
	 	</form>

		 <form name=\"prijatelji\" action=\" prijatelji.php\" method=\"post\">
	 		<input type=\"submit\" name=\"prijatelji\" value=\"Prijatelji\">
		 </form>

		 <form name=\"kalendar\" action=\" kalendar.php\" method=\"post\">
		 	<input type=\"submit\" name=\"kalendar\" value=\"Kalendar\">
		 </form>

		 <form name=\"kviz\" action=\"quiz.php\" method=\"post\">
		 	<input type=\"submit\" name=\"quiz\" value=\"Quiz\">
		 </form>
		 <hr>";
	}else{
		if($dbutil->daLiSmoPrijatelji($_SESSION["username"],$username1)){
		 	echo "<form method=\"post\">
					<input type=\"submit\" name=\"dodaj\" value=\"dodajPrijatelja\">
						<input type=\"hidden\" name=\"username1\" value=\"<?php echo $username1?>\">
				  </form>";
		}
	}

	?>
		 	<div class="posts">
	 		<?php
	 		if(!strcmp("$username1", "")){
	 			$postovi=$postDbUtil->getUsersPosts($_SESSION["username"]);
	 			echo "POSTOVI: <br> <br>";
	 			foreach ($postovi as $post) {
	 				echo $post["text"];
	 				echo $post["time"];
	 				echo "<br>";
	 			}
	 		}
	 		else{
	 			$postovi=$postDbUtil->getUsersPosts($username1);
	 			echo "POSTOVI: <br>  <br>";
	 			foreach ($postovi as $post) {

	 				echo $post["text"];
	 				echo $post["time"];
	 				echo "<br>";

	 			}
	 		}
	 		?>
<<<<<<< HEAD
		</filedset>
	</center>
	<?php
	if (isset($_POST['username'])==isset($_SESSION['username'])) {
    		# code...
    		$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        
			    } else {
			        echo "File is not an image.";
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			}
			// Check file size
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}
			// Check if $uploadOk is set to 0 by an error
			
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			    $result = $_GET['image']; 
				echo '<img src="images/gallery/<?php echo $result; ?>.jpg">';
    	}else{
    		/*$file = '../image.jpg';
			$type = 'image/jpeg';
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);*/
			$result = $_GET['image']; 
			echo '<img src="images/gallery/<?php echo $result; ?>.jpg">';
    	}
    	?>
    	<form action="profil.php" method="post">
		    Select image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload">
		    <input type="submit" value="Upload Image" name="submit">
		</form>
=======
	 		</div>

	 		<div class="posts">
		 		<?php
		 			$data1 = new Predlaganje();

					if(isset($_GET["username1"])) {
			 			$prijatelji = $data1->predlogPrijatelja($username1);
			 		}
			 		elseif (isset($_SESSION["username"])){
			 			$prijatelji = $data1->predlogPrijatelja($username);
			 		}

					echo "OSOBE KOJE MOZDA POZNAJETE? <br>  <br>";
					foreach ($prijatelji as $obj) {
							echo "<a href=\"profil.php?&username1=".$obj->getUsername()."\" >".$obj->getFirstName().$obj->getLastName()."</a>"."--->".$obj->getUsername();
							echo "<hr>";
					}
				?>
			</div>

			<div class="posts">
		 		<?php

		 			if(isset($_GET["username1"])) {
						$stranice = $data1->predlogStranica($username1);
					}
			 		elseif (isset($_SESSION["username"])){
			 			$stranice = $data1->predlogStranica($username);
			 		}

					echo "ZANIMLJIVE STRANICE :) <br> <br>";
					foreach ($stranice as $obj) {
						echo $obj->getNaziv() . " " . $obj->getOpis() . "<br>";
					}
				?>
			</div>

			<div class="posts">
		 		<?php

		 			if(isset($_GET["username1"])) {
						$grupe = $data1->predlogGrupa($username1);
					}
			 		elseif (isset($_SESSION["username"])){
			 			$grupe = $data1->predlogGrupa($username);
			 		}

					echo "ZANIMLJIVE GRUPE :) <br> <br>";
					foreach ($grupe as $obj) {
						echo $obj->getNaziv(). "<br>";
					}
				?>
			</div>
				
	 	
>>>>>>> 0b86a4da4cdb4020c61f8dccaa57412f90482685
<?php
include("footer.php");
?>
