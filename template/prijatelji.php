	<?php

		

session_start();
require_once("../db/UserDbUtil.php");
$id="";
if(isset($_SESSION["username"])){
			$id=$_SESSION["username"];
			$dbutil=new UserDbUtil();
			$user=$dbutil->findUserByUsername($id);
		}
		else{
			header("Location: login_form.php");
		}


?>
<?php
include("header.php");

$prijatelji=$dbutil->findFriendsByUsername($user["username"]);
		
		foreach($prijatelji as $prijatelj){
			
			$user=$dbutil->findUserByUsername($prijatelj["User_username1"]);

			echo "<a href=\"profil.php?&username1=".$user["username"]."\" >".$user["first_name"].$user["last_name"]."</a>"."--->".$user["username"];
			echo "<hr>";

		}
?>
</html>