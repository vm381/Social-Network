<?php
	/**
	* 
	*/
	define('COL_SPORT', 'sport');
	define('COL_MUSIC', 'muzika');
	define('COL_MOVIE', 'film');
	define('COL_ANIMAL', 'zivotinja');
	define('COL_BOOKS', 'knjige');
	define('COL_VIDEO', 'video');
	define('COL_EVENTS', 'dogadjaj');
	define('COL_TVPROGRAMMES', 'tvprogram');
	define('COL_APPSANDGAMES', 'appigre');
	define('COL_LIKES', 'lajk');
	define('COL_PHOTO', 'slika');
	define('COL_FRIEND', 'priatelj');
	define('COL_REVIEW', 'pregled');
	
	class Kategorija {
		private $kategorija;
		
		function __construct($kategorija)
		{
			$this->$kategorija=$kategorija;
		}
		public function dodajKategoriju(){
		# code...
		}

		function getKategorija(){
			return $this->$kategorija;
		}
		
		function setKategorija($kategorija){
			$this->$kategorija=$kategorija;
		}
	}
?>
	