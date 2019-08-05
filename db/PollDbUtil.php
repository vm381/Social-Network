<?php

	class PollDbUtil{


		private $conn;

		public function __construct($configFile = "config.ini")
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

    	public function __destruct()
    	{
       		$this->conn = null;
    	}

		public function insertPoll($user,$question, $time){
        	try {
            	$sql_existing_user = "SELECT * FROM User WHERE username" . "= :username";
            	$st = $this->conn->prepare($sql_existing_user);
            	$st->bindValue(":username", $username, PDO::PARAM_STR);
            	$existing_user = $st->fetch();
            	if ($st->fetch()) {
                	return false;
            	}

            	$sql_insert = "INSERT INTO Poll ($question,$time)"
                        ." VALUES (:question, :time)";

            	$st = $this->conn->prepare($sql_insert);
            	$st->bindValue("question", $question, PDO::PARAM_STR);
           		$st->bindValue("time", $time, PDO::PARAM_STR);
            
            	return $st->execute();
        	} catch (PDOException $e) {
            	return false;
        	}
    	}


    	public function getPolls($pageid){
        	try {
            	$sql = "SELECT * FROM Poll WHERE idPage=:id";
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("id", $pageid, PDO::PARAM_INT);
            	$st->execute();
            	return $st->fetchAll();
        	} catch (PDOException $e) {
            	return array();
        	}
    	}

    	
	}
	
?>