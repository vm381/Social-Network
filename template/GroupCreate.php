<?php

	require_once ("../db/UserDbUtil.php");
	require_once("../classes/Grupa.php");
	require_once ("../classes/Kategorija.php");
	session_start();

	if(isset($_SESSION["username"])){
		$id=$_SESSION["username"];
		$dbutil=new UserDbUtil();
		$user=$dbutil->findUser($username);
	}
	$admins=array();
	$target_dir = "pictures/";
	$target_file="";
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$dbutil;
	$pageObj;
	$datum=date('Y-m-d',strtotime('today'));
	
	
	//{PROVERA UPLOAD-a slike}
	if(isset($_POST["upload"])){
		$check=getimagesize($_FILES["image"]["tmp_name"]);
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		if($check!== false){
			$uploadOk=1;
		}else{
			echo "File is not an image";
			$uploadOk=0;
		}
		if($_FILES["image"]["size"] > 500000){
			echo "file too large";
			$uploadOk=0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $ImageFileType != "jpeg"){
			echo "Not alowed format only jpg , png or jpeg";
			$uploadOk=0;
		}
		if($uploadOk==0){
			echo "Error, file not uploaded";
		}else{
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
				echo "The file has been uploaded.";
			}else{
				"Error with uploading file";
			}
		}
		if(isset($_POST["create"])){
		$naziv=$_POST["naziv"];
		$kategorija=$_POST["kategorija"];
		$description=$_POST["description"];
		$groupObj=new Grupa($naziv, $id, $nizClanova, $kategorija, $target_file);
		$groupObj->saveGroup($naziv, $id, $nizClanova, $kategorija, $target_file);
	}
		if(isset($_POST["add"])){
			$usr=$_POST["adm"];
			$u=$dbutil->findUser($usr);
			$groupObj->dodajclanove($u);
		}
		
		
	}


?>
</!DOCTYPE html>
<html>
<head>
	<title>Group creation</title>
</head>
<body>
	<h2>Group Creation</h2>

	<form action="group_form.php" method="post" enctype="multipart/form-data">
		<fieldset>
		<label>Group name:</label>
		<input type="text" name="naziv">
		<br>	
		Short description:
		<br>
		<textarea name="description" rows="4" cols="30"></textarea>
		<br>
		<label>Upload photo</label>
		<input type="file" name="image"><input type="submit"name="upload" value="Upload">
		<br><br>
		<label> Select category: </label>
		<select name="category">
			<option value="<?php echo COL_SPORT;?>"><?php echo COL_SPORT;?></option>
			<option value="<?php echo COL_MUSIC;?>"><?php echo COL_MUSIC;?></option>
			<option value="<?php echo COL_MOVIE;?>"><?php echo COL_MOVIE;?></option>
			<option value="<?php echo COL_ANIMAL;?>"><?php echo COL_ANIMAL;?></option>
			<option value="<?php echo COL_BOOKS;?>"><?php echo COL_BOOKS;?></option>
			<option value="<?php echo COL_EVENTS;?>"><?php echo COL_EVENTS;?></option>
			<option value="<?php echo COL_TVPROGRAMMES;?>"><?php echo COL_TVPROGRAMMES;?></option>
			<option value="<?php echo COL_APPSANDGAMES;?>"><?php echo COL_APPSANDGAMES;?></option>
			
			</select>

		<br>
		<input type="submit" name="create" value="Create">
		</fieldset>

		<br>
	</form>
</body>
</html>