<?php
	require_once "classes/Kategorija.php";
	require_once "classes/User.php";
	require_once "classes/Answers.php";
	require_once "db/PollDbUtil.php";
	/**
	* 
	*/
	
	class Anketa {
		private $pitanje;
		private $odgovori=getAnswers($id);
		private $id;

		function __construct($id){
			$this->$id=$id;
			$this->$pitanje=$pitanje;
        	$this->$odgovori = array();
		}
		function getId()
		{
			return $this->$id;
		}

		function setId($id)
		{
			$this->$id=$id;
		}

		function getPitanja(){
			return $this->$pitanje;
		}

		function setPitanje($pitanje)
		{
			$this->$pitanje=$pitanje;
		}


		function getOdgovori()
		{
			return $this->$odgovori;
		}

		function setOdgovori($odgovor){
			array_push($odgovori, $odgovor);
		}

		public function getPoll($idp){
    		try {
            	$sql = "SELECT * FROM Poll WHERE idPoll". "=:id";
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("id", $idp, PDO::PARAM_INT);
           		$st->execute();
            	return $st->fetchAll();
        	} catch (PDOException $e) {
            	return array();
        	}
    	}

			/*$array = explode("\n", file_get_contents("User.txt"));
        	$kategorije = array();
        	foreach ($array["Kategorije"] as $value) {

        		$kategorija=new Kategorije($value);
        	}*/

	}


?>