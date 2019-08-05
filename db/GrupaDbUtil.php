<?php

class GroupDbUtil{

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
	public function saveGroup($Grupa){
		$sql_check= "SELECT * FROM Grupa WHERE naziv = :naziv";
		$st=$this->conn->prepare($sql_check);
		$st->bindValue(":naziv",$Grupa->getNaziv(),PDO::PARAM_STR);
		$exist_Grupa=$st->fetch();
		if($st->fetch()){
			return false;
		}
		$sql_insert="INSERT INTO Grupa(nazivGrupe, idGrupe, nizClanoveGrupe, kategorijaGrupe, slikaGrupe) VALUES(:naziv,:id,:nizClanova,:kategorija,:target_file)";
		$st=$this->conn->prepare($sql_insert);
		$st->bindValue(":naziv",$Grupa->getNaziv(), PDO::PARAM_STR);
		$st->bindValue(":id",$Grupa->getId(),PDO::PARAM_INT);
		$st->bindValue(":nizClanova",$Grupa->getNizClanova(),PDO::PARAM_STR);
		$st->bindValue(":kategorija",$Grupa->getKategorija(),PDO::PARAM_INT);
		$st->bindValue(":slika",$Grupa->getTargetFile(),PDO::PARAM_STR);

		return $st->execute();
		
	}
	public function loadPage($naz){
		$sql_find="SELECT * FROM Grupa WHERE naziv = :naziv";
		$st=$this->conn->prepare($sql_find);
		$st->bindValue(":naziv",$naz,PDO::PARAM_STR);
		return $st->fetch();

	}
}
 ?>
