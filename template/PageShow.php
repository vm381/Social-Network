<?php
require_once("../classes/Page.php");
require_once("../classes/User.php");
require_once("../classes/Post.php");
session_start();
$pdb=new PageDbUtil();
if (!isset($_SESSION["username"])) {
	header("Location: login_form.php");
}
$id="";
$page=null;
if(isset($_GET["id"])){
	$id=htmlspecialchars($_GET["id"]);

	$page=$pdb->loadPage($id);

}
if(isset($_SESSION["username"])){
	$username=$_SESSION["username"];
	$dbutil=new UserDbUtil();
	$user=$dbutil->findUserByUsername($username);
}
$pos="";
if(isset($_POST["objavi"])){
	$pos=htmlspecialchars($_POST["pos"]);

}
$apom=false;

if(isset($_GET["rel"])){
	$prom=htmlspecialchars($_GET["rel"]);
	if($prom =="a"){
		$admins=$pdb->getAdm($page->getId());
		$apom=true;
	}
}
$inf=false;
if(isset($_GET["info"])){
	$inf=htmlspecialchars($_GET["info"]);
}
if(isset($_POST["add"])){
	$usr=htmlspecialchars($_POST["add"]);
	$pdb->addAdmin($usr,$page->getId());

}
 $zappom=false;
 if(isset($_GET["zap"])){
 	$zappom=htmlspecialchars($_GET["zap"]);
 	$pdb->zaprati($_SESSION["username"],$page->getId());
 }
 $p=false;
 if(isset($_GET["post"])){
 	if($_GET["post"] == "true"){
 		$p=true;
 	}
 	}
?>
<?php include("header.php"); ?>
	<img src="<?php echo $page->getSlika();?>" height="100" width="100">

	<div><?php echo "{$page->getNaziv()}";?></div>
	<hr>
	<a href="?id=<?php echo $page->getId();?>&zap=true"><button <?php if($pdb->checkUsr($_SESSION["username"],$page->getId())){ echo "disabled";}?> >Zaprati stranicu</button></a>
		<br><a href="?id=<?php echo $page->getId();?>&post=true"><button>Prikazi postove</button></a><br>
	<a href="?id=<?php echo $page->getId();?>&rel=a"><button>Prikazi admine</button></a><br>
	<a href="?id=<?php echo $page->getId();?>&info=true"><button>Prikazi informacije</button></a><br>
	<hr>
	<center>
		<fieldset>
	<?php
	//PRIKAZI POSTOVE

		if($p){
			echo $page->postHtml();
			echo "<hr>";
			$p=false;
		}
		?>




		<?php
		//PRIKAZI ADMINE
		if($apom){
			foreach($admins as $adm){
				echo "Name:{$adm["first_name"]} {$adm["last_name"]} <br> Username: {$adm["username"]}
				<hr>";
			}
			$apom=false;
		}
		?>


		<?php
		//PRIKAZI INFORMACIJE
			if($inf=="true"){
				echo "Datum osnivanja: {$page->getDatum()}<br>";
				echo "Kategorija: {$page->getKategorija()}<br><br>";
				echo "Kratak opis: {$page->getOpis()}<br>";
			}
		?>
	</fieldset>
	</center>
	<?php

	if(isset($_POST["objavi"])){

	 $post = new Post(rand(0, 1000),$_SESSION["username"], htmlspecialchars($_POST["pos"]), date("Y-m-d H:i:s"));
	 $pdb->addPost($post,$page->getId());
	}

	if($pdb->checkAdm($_SESSION["username"],$page->getId())){
		echo "<form method=\"POST\">
		<input type=\"textarea\" name=\"pos\" row=\"6\">
		<input type=\"submit\" name=\"objavi\" value=\"Objavi\">
	</form>";
	?>
	<a href="?id=<?php echo $page->getId();?>&rel=d"><button>Dodaj admine</button></a>
		<?php
			if(isset($_GET["rel"])){
				if($_GET["rel"] == "d"){
					$page->addAdminHtml();
				}
			}
	}

	include("footer.php");
	?>
