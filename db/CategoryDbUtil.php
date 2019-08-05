<?php
	/**
	* 
	*/
	require_once("../classes/Post.php");
	require_once("../classes/Kategorija.php");
	class CategoryDbUtil{
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
		
		public static function readCategory(){
		
			$array=array();
			$arrayval=array();
			$arraynam=array();
			$fajl= fopen('category.txt','r');
			while ($line = fgets($fajl)) {
				if (is_numeric($line)) {
					$user=new User($line);
				}
				$array=explode("=", $line);
				for ($i=0; $i <13 ; $i++) { 
					$arraynam[$i]=$array[1];
					$arrayval[$i]=explode(',', $array[2]);
				}

        		
			}

        	fclose($fajl);
        	return $arrayval;

    	}

    	public function insertCategory($name)
    	{
    		try {
            	$sql = "INSERT INTO Category (name)"
                          ."VALUES (:name)";     
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("name", $name, PDO::PARAM_INT);
            	return $st->execute();
        	}	 catch (PDOException $e) {
            	return false;
        	}
    	}
    	public function getCategory($idcat){
    		try {
            	$sql = "SELECT * FROM Category WHERE idCategory". "=:id";
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("id", $idcat, PDO::PARAM_INT);
           		$st->execute();
            	return $st->fetchAll();
        	} catch (PDOException $e) {
            	return array();
        	}
    	}
    	public function saveCategory($post, $kategorija){
    		$fajl = fopen("category.txt", "w");

      		if ($fajl == false) {
        		return false;
      		}
      		$linija = $post->getId()."\n"."Kategorija:{"$Kategorija->getKategorija()"}"."\n";

      		fwrite($fajl, $linija);
      		fclose($fajl);
    	}
	}
	
?>