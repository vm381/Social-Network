<?php
	//getscore
	//header('Access-Control-Allow-Origin: *');
	$user=array();
	$array;
	$arrayd;
	$arrayval=array();
	
	/*
	$host="localhost"; 
	$username="username"; 
	$password="password"; 
	$db_name="database"; 
	$tbl_name="scores"; 

	$link = mysqli_connect("$host", "$username", "$password", "$db_name");


	$sql="SELECT * FROM scores ORDER BY score DESC LIMIT 20";	
	$result=mysql_query($sql);

	while($rows=mysqli_fetch_array($result)){
	echo $rows['name'] . "|" . $rows['score'] . "|";

	}
	mysql_close();

//savescore

$dblink = mysqli_connect($host,$dbu,$dbp,$db);

if(isset($_GET['name']) && isset($_GET['score'])){

     //Lightly sanitize the GET's to prevent SQL injections and possible XSS attacks
     $name = strip_tags(mysql_real_escape_string($_GET['name']));
     $score = strip_tags(mysql_real_escape_string($_GET['score']));
     
     $sql = mysqli_query($dblink, "INSERT INTO `$db`.`scores` (`id`,`name`,`score`) VALUES ('','$name','$score');");
     if($sql){
     
          //The query returned true - now do whatever you like here.
          echo 'Your score was saved. Congrats!';
          
     }else{
     
          //The query returned false - you might want to put some sort of error reporting here. Even logging the error to a text file is fine.
          echo 'There was a problem saving your score. Please try again later.';
          
     }
     
}else{
     echo 'Your name or score wasnt passed in the request. Make sure you add ?name=NAME_HERE&score=1337 to the tags.';
}

mysqli_close($dblink);//Close off the MySQL connection to save resources.*/
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	
		<div id="container">
		    
		    	<?php
		    	$file=fopen("../quizglobal.txt", "r");
				
				  //echo '<div>'.fgets($file).'</div>';
				  
				while ($line = fgets($file)) {
				
						$array=explode(";", $line);
						for ($i=0; $i <sizeof($array) ; $i++) { 
							# code...
						
						echo "<div>$array[$i]</div>";
					}
				}
        	
	
	

		/*for ($i=0; $i <sizeof($array); $i++) { 
			# code...
			echo "$array[$i]";
			$arrayd=explode(",", $array[$i]);
			# code...
		
		       	/*echo '<div class="row">
		       	<div class="name">';
		       	/*echo $arrayd[0].'</div>
		       	<div class="date">';
		       	echo $arrayd[1].'</div>
		       	<div class="score">'.$arrayd[2].'echo '</div>
		       	</div>'
		       	;
		       }*/
		       fclose($file);
		       	?>
		   
		</div>
	<form action="quiz.php" method="post">
		<a href="quiz.php"><input type="submit" name="quiz" value="quiz"></a>
	</form>
		<form action="history.php" method="post">
		<a href="history.php"><input type="submit" name="history" value="history"></a>
	</form>
	<form action="profil.php" method="post">
		<a href="profil.php"><input type="submit" name="profil" value="profil"></a>
	</form>
	<form action="leaderboard.php" method="post">
		<a href="leaderboard.php"><input type="submit" name="global" value="global"></a>
		</form>
	
</body>
</html>