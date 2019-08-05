<?php 
	
	include("header.php");

	require_once("../db/MessageDbUtil.php");
	require_once("../classes/Post.php");

	$msg = new MessageDbUtil();
	session_start();

	if(isset($_GET["dID"])) {
		$discussion_id = htmlspecialchars($_GET["dID"]);
		
		$posts = $msg->getDiscussionPosts($discussion_id);
		$posts = sortByTime($posts);
		foreach($posts as $post) {
			$p = new Post($post["idPost"], $post["User_username"], $post["text"], $post["time"], $post["likes"]);

			echo $p->getHtml();
		}

	}

	if(isset($_POST["submit"])) {
		$text = htmlspecialchars($_POST["text"]);
		$discussion_id = htmlspecialchars($_GET["dID"]);

		$p = new Post(rand(0, 100), $_SESSION["username"], $text, date("Y-m-d H:i:s"), 0);

		$msg->createPost($p, $discussion_id);
	}
?>


	<form action="discussion.php?dID=<?php echo $discussion_id; ?>" method="post"> 
		Text: <textarea cols="50" rows="4" name="text"> </textarea> <br>
		<input type="submit" name="submit" value="Postavi">
	</form>


<?php 

	function sortByTime($posts) {
		for($i = 0; $i < count($posts); $i++) {
			for($j = 1; $j < (count($posts) - $i); $j++) {								
				if(strtotime($posts[$j-1]["time"]) > strtotime($posts[$j]["time"])) {
					$tmp = $posts[$j];
					$posts[$j] = $posts[$j-1];
					$posts[$j-1] = $tmp;
				}
			}
		}
		return $posts;
	} 
	
	include("footer.php");

?>