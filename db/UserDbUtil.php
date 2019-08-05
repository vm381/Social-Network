<?php

	require_once("../classes/User.php");

	class UserDbUtil {

		private $conn;

        public function getCategoryByUser($username){
            try{
               $sql="SELECT * FROM CATEGORY WHERE idCategory=(SELECT  Category_idCategory FROM User_likes_Category  WHERE User_username=:idUser";
               $st=$this->conn->prepare($sql);
               $st->bindValue("idUser",$username,PDO::PARAM_STR);
              $st->execute();
              return $st->fetchAll();
            }catch(PDOException $e){
                return array();
            }
        }
        public function updateName($newName, $username){
            $sql="UPDATE User SET first_name=:newName WHERE username=:username";
            $st=$this->conn->prepare($sql);
            $st->bindValue("newName",$newName,PDO::PARAM_STR);
            $st->bindValue("username",$username,PDO::PARAM_STR);
            if($st->execute()){
                echo "uspesno promenjeno ime!";
            }
            else{
                echo "neuspesno promenjeno ime";
            }
        }
        public function updateLastName($newLastName,$username){
            $sql="UPDATE User SET last_name=:newLastName WHERE username=:username";
            $st=$this->conn->prepare($sql);
            $st->bindValue("newLastName",$newLastName,PDO::PARAM_STR);
            $st->bindValue("username",$username,PDO::PARAM_STR);
            if($st->execute()){
                echo "uspesno promenjeno prezime!";
            }
            else{
                echo "neuspesno promenjeno prezime";
            }
        }

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
        public function dodajPrijatelja($username,$username1){
            try{
                $sql = "INSERT INTO FRIENDS(User_username,User_username1) VALUES (:username,:username1)";
                $st = $this->conn->prepare($sql);
                $st->bindValue("username", $username);
                $st->bindValue("username1",$username1);
                return $st->execute();
            }catch(PDOException $e){
                return false;
            }
        }
        public function daLiSmoPrijatelji($username,$username1){
            try{
                $sql ="SELECT COUNT(1) FROM FRIENDS WHERE User_username1=:username1 and User_username=username";
                $st = $this->conn->prepare($sql);
                $st->bindValue("username", $username, PDO::PARAM_STR);
                $st->bindValue("username1", $username1, PDO::PARAM_STR);
                $st->execute();
                $pom=$st->rowCount();
                return $pom==0?false:true;
            }catch(PDOException $e){
                return false;
            }

          //pronalazenje prijatelja
        }
        public function findFriendsByUsername($username){
            try{
                $sql="SELECT User_username1 FROM FRIENDS WHERE User_username = :username";
                $st=$this->conn->prepare($sql);
                $st->bindValue("username",$username, PDO::PARAM_STR);
                $st->execute();
                $rez=$st->fetchAll();
                return $rez;
            }catch(PDOException $e){
                return array();
            }


        }
		public function saveUser($username, $password, $first_name, $last_name, $city, $school, $birthday, $gender) {
			// try {
            $sql_existing_user = "SELECT * FROM User WHERE username = :username";
            $st = $this->conn->prepare($sql_existing_user);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $existing_user = $st->fetch();
            if ($st->fetch()) {
                return false;
            }

            $sql_insert = "INSERT INTO User (username, password, first_name, last_name, birthday, city, school, gender) VALUES (:username, :password, :first_name, :last_name, :birthday, :city, :school, :gender)";

            $timest = strtotime($birthday);
            $date = date("Y-m-d", $timest);

            $st = $this->conn->prepare($sql_insert);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->bindValue(":password", $password, PDO::PARAM_STR);
            $st->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $st->bindValue(":last_name", $last_name, PDO::PARAM_STR);
            $st->bindValue(":city", $city, PDO::PARAM_STR);
            $st->bindValue(":school", $school, PDO::PARAM_STR);
            $st->bindValue(":birthday", $date, PDO::PARAM_STR);
            $st->bindValue(":gender", $gender, PDO::PARAM_STR);

            return $st->execute();
        //} catch (PDOException $e) {
        //    return false;
        //}
		}

		public function findUser($username, $password) {
			//try {
            $sql = "SELECT * FROM User WHERE username =:user and password =:password";
            $st = $this->conn->prepare($sql);
            $st->bindValue("user", $username, PDO::PARAM_STR);
            $st->bindValue("password", $password, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        //} catch (PDOException $e) {
        //    return array();
        //}
		}

        public function findUserByUsername($username) {
            //try {
            $sql = "SELECT * FROM User WHERE username =:user";
            $st = $this->conn->prepare($sql);
            $st->bindValue("user", $username, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        //} catch (PDOException $e) {
        //    return array();
        //}
        }

				public function getUsersFriends($username) {
					$sql = "select User_username1 from Friends where User_username = :username";
					$st = $this->conn->prepare($sql);
					$st->bindValue("username", $username, PDO::PARAM_STR);

					$st->execute();
					return $st->fetchAll();
				}

				public function getUsersPages($username) {
					$sql = "select * from Page where idPage = (select Page_idPage from User_Page where User_username = :username)";
					$st = $this->conn->prepare($sql);
					$st->bindValue("username", $username, PDO::PARAM_STR);

					$st->execute();
					return $st->fetchAll();
				}

	}

?>
