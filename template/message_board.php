<?php

	include("header.php");

?>

<?php

	require_once("../classes/MessageBoard.php");
	require_once("../classes/Message.php");
	require_once("../classes/Post.php");

	session_start();
	
	$mboard = new MessageBoard();
	if(isset($_POST["submit"])) {
		$title = htmlspecialchars($_POST["title"]);
		$sadrzaj = htmlspecialchars($_POST["sadrzaj"]);

		$post = new Post(rand(0, 100), $_SESSION["username"], $sadrzaj, date("Y-m-d H:i:s"));
		$mboard->createDiscussion($title, $post);
	}

	if(!isset($_GET["create"])) {
?>


<a href="message_board.php?create=true"> <button> Dodaj temu </button> </a> <br>

<?php

	}

	if(isset($_GET["create"]) && $_GET["create"] == true) {
?>
	<form action="message_board.php" method="post">
		Naslov teme: <input type="text" name="title"> <br> 
		Sadrzaj: <textarea rows="4" cols="50" name="sadrzaj"> </textarea> <br>

		<input type="submit" name="submit" value="Posalji">
	</form>

	<?php
	}

	

	if(!isset($_GET["create"])) {
		
		foreach($mboard->getDiscussions() as $disc) {
			echo "<a href=\"discussion.php?dID={$disc["idDiscusion"]}\"> {$disc["title"]} </a> <br>";
		} 
	}
?>

<?php

	include("footer.php");

?>