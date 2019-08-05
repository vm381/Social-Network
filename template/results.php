<?php
	require_once (".../db/QuizDbUtil.php");
	require_once ("../classes/Question.php");
	require_once ("../classes/Answer.php");

	$db=new QuizDbUtil("config1.ini");
	$que=new Question();
	$ans=new Answer();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<tbody>
			<tr>
				<td>
					<?php
					if (isset($_POST['submit'])) {

								
								if (!empty($_POST['quizc'])) {
									$count= count($_POST['quizc']);
									echo "Out of 10 you have selected ".$count." options";

									$correct = 0;
									for ($i=0; $i <10 ; $i++) { 
										# code...
										$id;
									$select=$_POST['quizc'];
									$array=array();	
										# code...
										# code...
									$id=$db->getAsnwers($ida)
									$check= $value==$select;
																		
					           		
					           		//$check=$id==$select[$id];
					           			# code...
					           			if ($check) {
						           				# code...
						           			$correct++;
						          		}
						           	}
						          	
					           		
			       				}
			   		}?>

				</td>
				<td>
				<?php
				//$arrays[$i][$j] = $_POST['$arrays['.$i.']['.$j.']'];

	    		$name=$_SESSION['username'];

	    		echo "<div id='results'>you have ".$correct." / 10 of correct</div>";
				$file=fopen("../db/files/$name/quiz.txt", "a");
				$now = date_create()->format('Y-m-d H:i:s');
				$txt = "\n"."$name,".$now.",$correct;";
				fwrite($myfile, $txt);
				//$t=$db->setUser($name,$name,$count,$correct);
				fclose($myfile);
	
				/*$file1=fopen("../$name/quiz.txt", "r");
				$txta=array();
				while ($line = fgets($file1)) {
				
						$array=explode("\n", $line);
						for ($i=0; $i <sizeof($array) ; $i++) { 
							$txta=$array[$i]."\n";

						}	
				}
				fclose($file1);*/


				$file2=fopen("../quizglobal.txt", "a");
				fwrite($file2, $txt);
				fclose($file2);

				/*$file3=file_get_contents('../quizglobal.txt');
				$line=explode($arrayval, $file3);
    			$file3=implode($max, $line);
				file_put_contents('quizglobal.txt', $file3);
*/
				//$file3=fopen("../quizglobal.txt", "r");
				/*$arrayval1=array();
				while ($line = fgets($file3)) {
						$array=explode("\n", $line);
						for ($i=0; $i <sizeof($array) ; $i++) { 
							$user=$array[0];
							$arrayvale[$i]=$array[2];
						}
						$repl=str_replace($txta, $arr, subject)
					*/?>
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<form action="quiz.php" method="post">
		<a href="quiz.php"><input type="submit" name="quiz" value="quiz"></a>
	</form>
	<form action="profil.php" method="post">
		<a href="profil.php"><input type="submit" name="profil" value="profil"></a>
	</form>
		<form action="history.php" method="post">
		<a href="history.php"><input type="submit" name="history" value="history"></a>
	</form>
	<form action="leaderboard.php" method="post">
		<a href="leaderboard.php"><input type="submit" name="global" value="global"></a>
		</form>
	
</body>
</html>