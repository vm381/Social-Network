<?php
	/**
	* 
	*/

	class QuizDbUtil{
		public function __construct($configFile = "config1.ini")
        {
            if ($config = parse_ini_file($configFile)) {
                $host = $config["host"];
                $database = $config["database"];
                $user = $config["user"];
                $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }
		

    	public function insertQuestion($idQuestion,$name,$answernum)
    	{
    		try {
            	$sql = "INSERT INTO question (qid, question, ans_id)"
                          ."VALUES (:idQuestion,:name,:ansid)";     
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("idQuestion", $idQuestion, PDO::PARAM_INT);
                $st->bindValue("name", $name, PDO::PARAM_STR);
                $st->bindValue("answernum", $answernum, PDO::PARAM_INT);

            	return $st->execute();
        	}	 catch (PDOException $e) {
            	return false;
        	}
    	}

    	public function getQuestion($idques){
    		try {
            	$sql = "SELECT * FROM question WHERE qid". "=:id";
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("id", $idques, PDO::PARAM_INT);
           		$st->execute();
            	return $st->fetchAll();
        	} catch (PDOException $e) {
            	return array();
        	}
    	}
        public function getAsnwers($ida){
            try {
                $sql = "SELECT ans_id FROM question WHERE qid". "=:id";
                $st = $this->conn->prepare($sql);
                $st->bindValue("id", $ida, PDO::PARAM_INT);
                $st->execute();
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }

        public function setUser($id,$username,$total,$correct){
            try {
                $sql = "INSERT INTO user (id, username, totalque, correct)"
                          ."VALUES (:idQuestion,:name,:ansid ,:corret)";     
                $st = $this->conn->prepare($sql);
                $st->bindValue("idQuestion", $id, PDO::PARAM_INT);
                $st->bindValue("name", $username, PDO::PARAM_STR);
                $st->bindValue("answernum", $total, PDO::PARAM_INT);
                $st->bindValue("corret", $correct, PDO::PARAM_INT);
                return $st->execute();
            }    catch (PDOException $e) {
                return false;
            }
        }
       /* public function getAsnwers($idques){
            try {
                $sql = "SELECT * FROM Question WHERE idQuestion". "=:id";
                $st = $this->conn->prepare($sql);
                $st->bindValue("id", $idques, PDO::PARAM_INT);
                $st->execute();
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }*/
    	/*public function saveCategory($post, $kategorija){
    		$fajl = fopen("category.txt", "w");

      		if ($fajl == false) {
        		return false;
      		}
      		$linija = $post->getId()."\n"."Kategorija:{"$Kategorija->getKategorija()"}"."\n";

      		fwrite($fajl, $linija);
      		fclose($fajl);
    	}*/
	}
	
?>