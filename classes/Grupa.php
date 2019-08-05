<?php class Grupa {
	private $naziv;
	private $id;
	private $nizClanova;
	private $kategorija;
	private $target_file;
	
	public function __construct($naziv, $id, $nizClanova, $kategorija, $target_file) {
		$this->naziv=$naziv;
		$this->id=$id;
		$this->nizClanova=array();
		$this->kategorija=$kategorija;
		$this->target_file=$target_file;
	}

	public function getNaziv(){
		return $this->naziv;
	}

	public function getId(){
		return $this->id;
	}
	
	public function getNizClanova() {
		return $this->nizClanova();
	}

	public function getKategorija() {
		return $this->kategorija;
	}

	public function getTargetFile() {
		return $this->target_file;
	}

	public function setNaziv($naziv) {
		$this->naziv=$naziv;
	}

	public function setId($id) {
		$this->id=$id;
	}

	public function setNizClanova($nizClanova){
		$this->nizClanova=$nizClanova;
	}

	public function setKategorija($kategorija) {
		$this->kategorija=$kategorija;
	}

	public function setTargetFile($target_file) {
		$this->target_file=$target_file;
	}

	public function dodajclanove($username){
		if(is_a($username,"User")){
			$this->nizClanova[]=$username;
		}
	}

	public function saveGroup($naziv, $id, $nizClanova, $kategorija, $target_file) {
		$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/tim1/db/files/Grupa.txt", "a");
		$Grupa = $naziv . "," . $id . "," . $nizClanova . "," . $kategorija . "," . $target_file . "\n";

		$ok = fwrite($file, $Grupa);
		fclose($file);
		return $ok;
	}


}
?>