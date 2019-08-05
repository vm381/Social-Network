
<?php
	require_once ("../db/UserDbUtil.php");
	require_once("../classes/Page.php");
	require_once ("../classes/Kategorija.php");
	require_once("../db/PageDbUtil.php");
	session_start();

	if(isset($_SESSION["username"])){
		$id=$_SESSION["username"];
		$dbutil=new UserDbUtil();
		$user=$dbutil->findUserByUsername($id);
	}
	$admins=array();

	$target_file="";
	$uploadOk = true;
	//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$dbutil;
	$pageObj;
	$datum=date('Y-m-d',strtotime('today'));
	$pdb=new PageDbUtil();
	$kat=$pdb->getCategory();

	//{PROVERA UPLOAD-a slike}
	if(isset($_POST["create"])){
		$check=getimagesize($_FILES["image"]["tmp_name"]);
		$target_file = "../slike/" . basename($_FILES["image"]["name"]);
		if($check!== false){
			$uploadOk=true;
		}else{
			echo "File is not an image";
			$uploadOk=false;
		}

	//	if($imageFileType != "jpg" && $imageFileType != "png" && $ImageFileType != "jpeg"){
	//		echo "Not alowed format only jpg , png or jpeg";
	//		$uploadOk=0;
	//	}
		if($uploadOk==false){
			echo "Error, file not uploaded";
		}else{
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
				echo "The file has been uploaded.";
			}else{
				"Error with uploading file";
			}
		}

		$name=htmlspecialchars($_POST["page_name"]);
		$cat=htmlspecialchars($_POST["category"]);
		$desc=htmlspecialchars($_POST["desc"]);
		$pageObj=new Page(rand(0,1000),$name,$cat,$desc,$datum,$user["username"],$target_file);
		$pdb->savePage($pageObj);
		header("Location: PageShow.php?id={$pageObj->getId()}");
	}
		//	if(isset($_POST["add"])){
		//	$usr=$_POST["adm"];
		//	$u=$dbutil->findUser($usr);
		//	$pageObj->dodajAdmine($u);
		//}

	include("header.php");

?>
	<h2>Page Creation</h2>
	<form action="page_form.php" method="post" enctype="multipart/form-data">
		<fieldset>
		<label>Page name:</label>
		<input type="text" name="page_name">
		<br><br>
		<label> Select category: </label>
		<select name="category"> <!-- preuzmi iz kategorije -->
			<?php
				foreach ($kat as $value) {
					echo "<option value=\"{$value->getId()}\">{$value->getName()}</option>";
				}
			?>
			</select>

		<br><br>

		Short description:
		<br><br>
		<textarea name="desc" rows="4" cols="30"></textarea>
		<br><br>
			<!-- Add admin (enter username)</label>
		<input type="text" name="adm"> <input type="submit" name="add" value="Add">
		<br><br> -->
		<label>Upload photo</label>
		<input type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
		<!--<input type="submit"name="upload" value="Upload"> -->
		<br><br>

		<input type="submit" name="create" value="Create">
		</fieldset>
		</form>
	<?php
	include("footer.php");
	?>
