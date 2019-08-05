<?php
 require ("../header.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
	if (isset($_POST['username'])==isset($_SESSION['username'])) {
    		# code...
    		$target_dir = "Slike/";
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
				echo '<img src="Slike/<?php echo $result; ?>.jpg">';
    	}else{
    		/*$file = '../image.jpg';
			$type = 'image/jpeg';
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);*/
			$result = $_GET['image']; 
			echo '<img src="Slike/<?php echo $result; ?>.jpg">';
    	}
    	?>
    	<form action="upload.php" method="post">
		    Select image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload">
		    <input type="submit" value="Upload Image" name="submit">
		</form>
		<br>
		<form action="profil.php" method="post">
		<a href="profil.php"><input type="submit" name="profil" value="profil"></a>
	</form>
</body>
</html>