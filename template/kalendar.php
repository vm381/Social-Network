<?php 
	require_once('../classes/Event.php'); 
	require_once('../db/EventDbUtil.php');
	include("header.php");
	include("footer.php");
	
	session_start();
	$user = '';
	if (!isset($_SESSION["username"])) {
    	header("Location: login_form.php");
  	}
	else {
		$user = $_SESSION["username"];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Kalendar </title>
	<style>
		table.tabela {
		  border: 4px solid #727272;
		  background-color: #727272;
		  width: 400px;
		  text-align: center;
		  border-collapse: collapse;
		  margin:auto;
		}
		table.tabela td {
		  border: 1px solid #727272;
		  padding: 5px 10px;
		}
		table.tabela th {
		  background: #398AA4;
		}
		table.tabela td.selected {
		  background: #398AA4;
		}
		table.tabela td.current {
		  background: #8b0000;
		}
		table.tabela a{
			font-weight: bold;
			color: black;
		}

		div.forma{
			font-weight: bold;
			background-color: #727272;
			width: 400px;
			margin: 20px auto;
			border-style: solid;
  			border-width: 1px;
		}
		div.forma fieldset{
			background: #398AA4;
		}

	</style>
</head>
<body>
	<?php
		// SKRIPTA UZIMA USERNAME IZ SESIJE

		//=========================		DOGADJAJI	==============================
		$database = new EventDatebase();

		$dogadjaji = $database->ucitajDogadjajeKorisnika($user);

		if(isset($_GET["unesi"])){
			$dog = new Event('',$_GET["name"],$_GET["date"],$_GET["time"],$_GET["izborKat"]);
			// sinhronizacija niza
			$dogadjaji[] = $dog;
			// sinhronizacija baze
			$database->sacuvajDogadjajKorisnika($user,$_GET["name"],$_GET["date"],$_GET["time"],$_GET["izborKat"]);

		}
		else if(isset($_GET["obrisi"])){
			$dog = NULL;
			foreach ($dogadjaji as $obj) {
				if($obj->getName() == $_GET["name"]){
					$dog = $obj;
					// sinhronizacija niza
					$key = array_search($obj, $dogadjaji);
					array_splice($dogadjaji, $key, 1);
				}	
			}
			// sinhronizacija baze
			$database->obrisiDogadjaj($user,$dog->getName(),$dog->getCategory());
		} 

		//=========================		DATUM	===================================
		$date = new DateTime();	// Prosledjen datum, ako ga nema onda trenutni
		if(isset($_GET["newDate"])){
			$date = DateTime::createFromFormat('d/m/|Y',$_GET["newDate"]);
		} 
		// Dan prosledjenog datuma
		$day = $date->format('d');	
		// Mesec prosledjenog datuma
		$month = $date->format('m');	
		// Godina prosledjenog datuma
		$year = $date->format('Y');		
		// Mesec slovima prosledjenog datuma
		$strMonth = $date->format('F'); 

		$tempDate = DateTime::createFromFormat('d/m/|Y',$date->format('d/m/Y'));
		// Sledeci mesec od prosledjenog datuma
		$nextDate = $tempDate->modify( '+1 month' )->format('d/m/Y');	
		// Prethodni mesec od prosledjenog datuma
		$prevDate = $tempDate->modify( '-2 month' )->format('d/m/Y');	

		//=========================		TABELA	===================================
		echo "<table class=\"tabela\">
				<tr>
			    	<th colspan=\"7\"> 
				    	<a href=\"?newDate=$prevDate\"> << </a>
				    	$strMonth	
				    	$year 
				    	<a href=\"?newDate=$nextDate\"> >> </a>
			    	</th>
		  		</tr>
		 		<tr>
			    	<th>MON</th>
			    	<th>TUE</th> 
			    	<th>WED</th>
			    	<th>THU</th>
			    	<th>FRI</th>
			    	<th>SAT</th>
			    	<th>SUN</th>
		  		</tr>";

		// prvi dan u nedelji u mesecu prosledjenog datuma 		
		$prevEscape = EventDatebase::prviDanUMesecu($strMonth, $year);
		// poslednji dan u nedelji u mesecu prosledjenog datuma
		$nextEscape = EventDatebase::poslDanUMesecu($strMonth, $year);

		// prazna polja na pocetku kalendara
		for ($j=1; $j <= $prevEscape; $j++) { 
			if($j % 7 == 1)
				echo "<tr>";
			echo "<td></td>";
		}

		$curr = 1;
		for ($i = $prevEscape+1; $i <= cal_days_in_month(CAL_GREGORIAN, $month, $year) + $prevEscape; $i++) { 
			if($i % 7 == 1)
				echo "<tr>";

			$datum = DateTime::createFromFormat('d/m/Y', "$curr/$month/$year");
			$datum = $datum->format('d/m/Y');
			if($day == $curr)
				echo "<td class=\"current\"> <a href=\"?newDate=$datum\"> $curr </a> </td>";
			else
				if(EventDatebase::postojiDogadjaj($dogadjaji, "$curr/$month/$year"))
					echo "<td class=\"selected\"> <a href=\"?newDate=$datum\"> $curr </a> </td>";
				else
					echo "<td> <a href=\"?newDate=$datum\"> $curr </a> </td>";
			$curr++;

			if($i % 7 == 0)
				echo "</tr>";
		}

		// prazna polja na kraju kalendara
		for ($j=1; $j <= $nextEscape; $j++) { 
			echo "<td></td>";
		}

		echo "</table>";

		//=========================		FORMA	=====================================
		// String prosledjenog datuma
		$strDate = $date->format('d/m/Y');

		if(!isset($_GET["submit"])){

			echo "<div class=\"forma\">";
			echo "<h1><b> $strDate </b></h1>";

			$nadjen = false;
			foreach($dogadjaji as $obj){	
				if($obj->getDate() == $strDate){
					echo EventDatebase::htmlZaDogadjaj($obj, $strDate);
					$nadjen = true;
				}
			}
			if(!$nadjen)
				echo "Nema dogadjaja <br>";

			echo "<br> <a href=\"?newDate=$strDate&submit=SUBMIT\"> <button> DODAJ </button> </a>";

			echo "</div>";

		}
		else{
			$kategorije = $database->ucitajKategorije();
			$izborKat = $database->htmlZaKategorije($kategorije);
			echo "<div class=\"forma\"> <h1><b> $strDate </b></h1> <form method=\"get\">";
			echo "<fieldset>
				  <legend> Unos dogadjaja </legend>
				 	Naziv: <input type=\"text\" name=\"name\" > <br>
				 	Vreme: <input type=\"time\" name=\"time\" > <br>" 
				 	. $izborKat . 
				 	"<br> <br> <input type=\"hidden\" name=\"date\" value=\"$strDate\">
				 	<input type=\"hidden\" name=\"newDate\" value=\"$strDate\">
				 	<input type=\"submit\" name=\"unesi\" value=\"UNESI\">
				 	<input type=\"submit\" value=\"PONISTI\">
				 </fieldset>";
			echo "</form> </div>";
		}
	?>
</body>
</html>