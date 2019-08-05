<?php

	require_once("../classes/Message.php");
	require_once("../classes/Post.php");

	class MessageDbUtil {

		private $conn;

		public function __construct($configFile = "config.ini") {
       		if ($config = parse_ini_file($configFile)) {
            	$host = $config["host"];
            	$database = $config["database"];
            	$user = $config["user"];
            	$password = $config["password"];
            	$this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	}
    	}

   	 	public function __destruct() {
        	$this->conn = null;
    	}

    	public function getDiscussions() {
    		$sql = "SELECT * FROM Discusion";
    		$sql = $this->conn->prepare($sql);
    		$sql->execute();

    		return $sql->fetchAll();
    	}

    	public function createDiscussion($title, $post) {
    		$sql = "INSERT INTO Discusion (idDiscusion, title, Group_idGroup) VALUES (:idD, :title, :idG)";
    		$sql = $this->conn->prepare($sql);
    		$discusion_id = rand(0, 100);
    		$sql->bindValue("idD", $discusion_id, PDO::PARAM_INT);
    		$sql->bindValue("title", $title, PDO::PARAM_STR);
    		$sql->bindValue("idG", 1, PDO::PARAM_INT);

    		if(!$sql->execute()) {
    			return false;
    		}


    		$sql = "INSERT INTO Post (idPost, text, time, User_username, likes, Discusion_idDiscusion) VALUES (:idP, :text, :time, :user, :likes, :idD)";
    		$post_id = rand(0, 100);
    		$sql = $this->conn->prepare($sql);
    		$sql->bindValue("idP", $post_id, PDO::PARAM_INT);
    		$sql->bindValue("text", $post->getText(), PDO::PARAM_STR);
    		$sql->bindValue("time", $post->getTime(), PDO::PARAM_STR);
    		$sql->bindValue("user", $post->getUser(), PDO::PARAM_STR);
    		$sql->bindValue("likes", 0, PDO::PARAM_INT);
    		$sql->bindValue("idD", $discusion_id, PDO::PARAM_INT);

    		if(!$sql->execute()) {
    			return false;
    		}

    		return true;
    	}

    	public function getDiscussionPosts($dID) {
    		$sql = "SELECT * FROM Post WHERE Discusion_idDiscusion =:idP";
    		$sql = $this->conn->prepare($sql);

    		$sql->bindValue("idP", $dID, PDO::PARAM_INT);
    		$sql->execute();
    		return $sql->fetchAll();
    	}

    	public function createPost($post, $dID) {

    		$sql = "INSERT INTO Post (idPost, text, time, User_username, likes, Discusion_idDiscusion) VALUES (:idP, :text, :time, :user, :likes, :idD)";
    		$post_id = rand(0, 100);
    		$sql = $this->conn->prepare($sql);
    		$sql->bindValue("idP", $post_id, PDO::PARAM_INT);
    		$sql->bindValue("text", $post->getText(), PDO::PARAM_STR);
    		$sql->bindValue("time", $post->getTime(), PDO::PARAM_STR);
    		$sql->bindValue("user", $post->getUser(), PDO::PARAM_STR);
    		$sql->bindValue("likes", 0, PDO::PARAM_INT);
    		$sql->bindValue("idD", $dID, PDO::PARAM_INT);

    		if(!$sql->execute()) {
    			return false;
    		}

    		return true;
    	}

	}

?>
