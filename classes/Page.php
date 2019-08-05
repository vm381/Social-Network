<?php 
require_once("../db/PageDbUtil.php");

	 class Page{
	 	private $id;
		private $naziv;
		private $kategorija;
		private $opis;
		private $datum;
		private $osnivac;
		private $admini;
		private $slika;

	
	public function __construct($id,$naziv, $kategorija,$opis,$datum,$osnivac,$slika){
		$this->id=$id;
		$this->naziv=$naziv;
		$this->kategorija=$kategorija;
		$this->opis=$opis;
		$this->datum=$datum;
		$this->osnivac=$osnivac;
		$this->admini=array();	
		$this->slika=$slika;
	}
	public function dodajAdmine($username){
		if(is_a($username,"User")){
			$this->admini[]=$username;
		}
	}
	public function getId(){
		return $this->id;
	}
	public function getSlika(){
		return $this->slika;
	}
	public function getOpis(){
		return $this->opis;
	}
	
	public function getKategorija(){
		return $this->kategorija;
	}
	public function getNaziv(){
		return $this->naziv;
	}
	public function getDatum(){
		return $this->datum;
	}
	public function getVlasnik(){
		return $this->osnivac;
	}
	public function getAdmini(){
		return $this->admini;
	}
	public function savePage($naziv,$kategorija,$opis,$datum,$osnivac,$slika){
		$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/tim1/db/files/pages.txt", "a");
		$page= $id.",".$naziv . "," . $kategorija . "," . $opis . "," . $datum . "," . $osnivac . "," . $slika . "\n";

		$ok=fwrite($file, $page);
		fclose($file);
		return $ok;


	}
	public function postHtml(){
		$db=new PageDbUtil();
		$posts=$db->getPagePosts($this->getId());

		$html="<div>";
		foreach($posts as $post){
			$html.="<div><{$this->getNaziv()}</div>";
			$html.="<div>{$post->getText()}</div>";
			$html.="<div>{$post->getTime()}</div>";
		}
		$html.="</div>";
		return $html;
	}
	public function addAdminHtml(){
		
		echo "<form method=\"POST\">
		<label for=\"adm\"> Add admin (enter username)</label>
		<input type=\"text\" name=\"adm\"> 
		<input type=\"submit\" name=\"add\" value=\"Add\">
		<br><br> 
	</form>";
	}
}
?>