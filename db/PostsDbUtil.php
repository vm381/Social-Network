<?php
require_once("../classes/Post.php");

class PostsDbUtil {

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

  public function getUsersPosts($username) {
    $sql = "select * from Post where User_username = :username";
    $st = $this->conn->prepare($sql);
    $st->bindValue("username", $username, PDO::PARAM_STR);
    $st->execute();
    return $st->fetchAll();
  }

  public function addPost($post) {
    $sql = "insert into Post (idPost, text, time, User_username, likes) values (:id, :text, :time, :user, :likes)";
    $st = $this->conn->prepare($sql);
    $st->bindValue("id", $post->getId(), PDO::PARAM_STR);
    $st->bindValue("text", $post->getText(), PDO::PARAM_STR);
    $st->bindValue("time", $post->getTime(), PDO::PARAM_STR);
    $st->bindValue("user", $post->getUser(), PDO::PARAM_STR);
    $st->bindValue("likes", $post->getLikes(), PDO::PARAM_INT);

    return $st->execute();
  }

  public function updateLikes($postId, $likes) {
    $sql = "update Post set likes = :likes where idPost = :id";
    $st = $this->conn->prepare($sql);
    $st->bindValue("likes", $likes, PDO::PARAM_INT);
    $st->bindValue("id", $postId, PDO::PARAM_INT);

    return $st->execute();
  }

  public function getPostById($id) {
    $sql = "select * from Post where idPost = :id";
    $st = $this->conn->prepare($sql);
    $st->bindValue("id", $id, PDO::PARAM_INT);

    $st->execute();
    $result = $st->fetch();
    $post = new Post($result["idPost"], $result["User_username"], $result["text"], $result["time"], $result["likes"]);
    
    return $post;
  }

}
 ?>
