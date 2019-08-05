<?php
require_once("../classes/Page.php");
require_once("../classes/Category.php");
require_once("../classes/Post.php");

class PageDbUtil{

	private $conn;

	public function __construct($configFile="config.ini"){
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

	public function savePage($page){
		$sql_check= "SELECT * FROM Page WHERE idPage = :id";
		$st=$this->conn->prepare($sql_check);
		$st->bindValue(":id",$page->getId(),PDO::PARAM_INT);
		$exist_page=$st->fetch();
		if($st->fetch()){
			return false;
		}
		$sql_insert="INSERT INTO Page(idPage, name, Category_idCategory, dateFounded, description, picture) VALUES(:id,:name,:category,:dat,:description,:picture)";
		$st=$this->conn->prepare($sql_insert);
		$st->bindValue(":id",$page->getId(), PDO::PARAM_INT);
		$st->bindValue(":name",$page->getNaziv(),PDO::PARAM_STR);
		$st->bindValue(":category",$page->getKategorija(),PDO::PARAM_INT);
		$st->bindValue(":dat",$page->getDatum(),PDO::PARAM_STR);
		$st->bindValue(":description",$page->getOpis(),PDO::PARAM_STR);
		$st->bindValue(":picture",$page->getSlika(),PDO::PARAM_STR);

		$st->execute();

		$sql_insertA="INSERT INTO User_Page(User_username,Page_idPage,admin) VALUES (:username,:id,:adm)";
		$st=$this->conn->prepare($sql_insertA);
		$st->bindValue(":username",$page->getVlasnik(),PDO::PARAM_STR);
		$st->bindValue(":id",$page->getId(),PDO::PARAM_INT);
		$st->bindValue(":adm",true,PDO::PARAM_BOOL);

		return $st->execute();

	}
	public function loadPage($id){
		$sql_find="SELECT * FROM Page WHERE idPage = :id";
		$st=$this->conn->prepare($sql_find);
		$st->bindValue(":id",$id,PDO::PARAM_INT);
		$st->execute();
		$res= $st->fetch();

		$sql_findA="SELECT * FROM User_Page WHERE Page_idPage =:id AND admin =:da";
		$st=$this->conn->prepare($sql_findA);
		$st->bindValue(":id",$id,PDO::PARAM_INT);
		$st->bindValue(":da",true,PDO::PARAM_BOOL);
		$st->execute();
		$us=$st->fetch();
		$page=new Page($res["idPage"],$res["name"],$res["Category_idCategory"],$res["description"],$res["dateFounded"],$us["User_username"],$res["picture"]);

		return $page;
	}
	public function addPost($post,$page){
	$sql = "INSERT INTO Post (idPost, text, time, User_username, likes, Page_idPage) VALUES (:id, :text, :time, :user, :likes, :idP)";
    $st = $this->conn->prepare($sql);
    $st->bindValue("id", $post->getId(), PDO::PARAM_STR);
    $st->bindValue("text", $post->getText(), PDO::PARAM_STR);
    $st->bindValue("time", $post->getTime(), PDO::PARAM_STR);
    $st->bindValue("user", $post->getUser(), PDO::PARAM_STR);
    $st->bindValue("likes", $post->getLikes(), PDO::PARAM_INT);
    $st->bindValue(":idP",$page,PDO::PARAM_INT);
    return $st->execute();
  }


	public function getPagePosts($page){
		$sql="SELECT * FROM Post WHERE Page_idPage = :id";
		$st=$this->conn->prepare($sql);
		$st->bindValue(":id",$page,PDO::PARAM_INT);
		$st->execute();
		$posts=$st->fetchAll();
		$pom=array();
		foreach ($posts as $post) {
			$id=$post["idPost"];
			$user=$post["User_username"];
			$text=$post["text"];
			$time=$post["time"];
			$likes=$post["likes"];

			$pom[]=new Post($id,$user,$text,$time,$likes);
		}
		return $pom;

	}

	public function checkAdm($user,$page){
	$sql="SELECT * FROM User_Page WHERE User_username = :username AND admin = :da and Page_idPage =:id";
	$st=$this->conn->prepare($sql);
	$st->bindValue(":username",$user,PDO::PARAM_STR);
	$st->bindValue(":da",true,PDO::PARAM_BOOL);
	$st->bindValue(":id",$page,PDO::PARAM_INT);
	$st->execute();
	if(!$st->fetch()){
		return false;
	}
	return true;
}
	public function checkUsr($user,$page){
		$sql="SELECT * FROM User_Page WHERE User_username =:username AND Page_idPage=:id";
		$st=$this->conn->prepare($sql);
		$st->bindValue(":username",$user,PDO::PARAM_STR);
		$st->bindValue(":id",$page,PDO::PARAM_INT);
		$st->execute();
		if(!$st->fetch()){
			return false;
		}
		return true;
	}

	public function getCategory(){
		  try {
            $sql_categories = "SELECT * FROM Category";
            $st = $this->conn->prepare($sql_categories);
            $st->execute();
            $fetch = $st->fetchAll();

            $kat = array();
            foreach ($fetch as $f) {
                $id = $f["idCategory"];
                $name = $f["name"];

                $kat[] = new Category($id,$name);
            }
            return $kat;
        } catch (PDOException $e) {
            return false;
        }
	}

	public function getAdm($page){
		$sql="SELECT * FROM User WHERE username = (SELECT User_username FROM User_Page WHERE Page_idPage = :id AND admin = :bol)";
		$st=$this->conn->prepare($sql);
		$st->bindValue(":id",$page,PDO::PARAM_INT);
		$st->bindValue(":bol",true,PDO::PARAM_BOOL);
		$st->execute();
		$pom=$st->fetchAll();

		return $pom;
	}

	public function addAdmin($username,$page){
		try{
		// $sql_insertA="INSERT INTO User_Page(User_username,Page_idPage,admin) VALUES (:username,:id,:adm)";
		// $st=$this->conn->prepare($sql_insertA);
		// $st->bindValue(":username",$username,PDO::PARAM_STR);
		// $st->bindValue(":id",$page,PDO::PARAM_INT);
		// // $st->bindValue(":adm",true,PDO::PARAM_BOOL);
		// //MOZDA UPDATE
		$sqlU="UPDATE User_Page SET admin=:bol WHERE User_username = :user AND Page_idPage= :id";
		$st=$this->conn->prepare($sqlU);
		$st->bindValue(":user",$username,PDO::PARAM_STR);
		$st->bindValue(":id",$page,PDO::PARAM_INT);
		$st->bindValue(":bol",true,PDO::PARAM_BOOL);
		return $st->execute();
		}catch(PDOException $e){
			return false;
		}
	}

	 public function zaprati($username,$page){
	 	try{
	 	$sql_insertA="INSERT INTO User_Page(User_username,Page_idPage,admin) VALUES (:username,:id,:adm)";
	 	$st=$this->conn->prepare($sql_insertA);
	 	$st->bindValue(":username",$username,PDO::PARAM_STR);
	 	$st->bindValue(":id",$page,PDO::PARAM_INT);
	 	$st->bindValue(":adm",false,PDO::PARAM_BOOL);

	 	return $st->execute();
	 	}catch(PDOException $e){
	 		return false;
	 	}
	 }

}
 ?>
