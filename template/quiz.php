<?php
require_once ("../classes/Question.php");
require_once ("../classes/Answer.php");
require_once ("../db/QuizDbUtil.php");

session_start();
if (!isset($_SESSION['username'])) {
	header('location:login.php');
}

$db=new QuizDbUtil("config1.ini");
$que=new Question();
$ans=new Answer();
?>
<?php
include("header.php");
?>
	<div class="questions">
		<div class="cards" >
			<h2>Welcome <?php echo 1;echo $_SESSION['username']?> to quiz </h2>
			<br>
		</div>
			<center>
			<form action="results.php" method="post">
				<?php
				//$arrays=array();
				$arrays=getQuestions();
				/*$arrays=array( 
					array("qid","name","ansid","111t", "1","121","24","24","24","24"),
					array("ase1","2","22","222t", "2","122","24","24","24","24"),
					array("ase2","3","33s","333t", "33s","123","24","24","24","24"),
					array("ase3","4","44s","444t", "444t","124","24","24","24","24"),
					array("ase4","5","55s","555t", "5","125","24","24","24","24"),
					array("ase5","6","66s","666t", "66s","126","24","24","24","24"),
					array("ase6","7","77s","777t", "7","127","24","24","24","24"),
					array("ase7","8","88s","888t", "8","128","24","24","24","24"),
					array("ase8","9","99s","999t", "99s","129","24","24","24","24"),
					array("ase9","10","100s","t", "t","120","24","24","24","24"),
			);*/
				
				for ($j=0; $j<10; $j++) { 
					echo '<h4>'.$arrays[$j][1].'</h4>';
					/*$q="select * from answer where ans_id=: $k";
					$querry=mysql_query($q);
					while ($rows=mysql_fetch_array($querry)) {*/
						# code...
						
						
							# code...
					//echo '';
					//for ($k=1; $k <=3; $k++) { 	
					?>	
					<div class="cards">
					<div class="body">
<<<<<<< HEAD
						
								<input type="radio" id="num[]" name="quizc[<?php echo($arrays[$j][2]);?>]" value="<?php echo($ans->getAnswers($ansid));?>">
							
=======
								<input type="radio" id="num[<?php echo($arrays[$j][5]);?>]" name="quizc[<?php echo($arrays[$j][4]);?>]" value="<?php echo($arrays[$j][$i]);?>">
>>>>>>> 0b86a4da4cdb4020c61f8dccaa57412f90482685
								<?php
								/*num($array[$j][0])*/
								/*$arrays[$j][4]*/
									echo $ans->getAnswers($ansid);
								//}
						echo '</div>';
							
						echo '</div>';
					
					
				}
				?>
				<input type="submit" name="submit" value="Submit">
			</form>
			</center>

		
	</div>
	<!--
		<fieldset>
		<legend>What is your JavaScript library of choice?</legend>
		<form action="<?php //echo $editFormAction; ?>" id="form1" name="form1" method="POST">
			<label>
				<input type="radio" name="Poll" value="mootools" id="Poll_0" />
				Mootools
			 </label>
			<label>
				<input type="radio" name="Poll" value="prototype" id="Poll_1" />
				Prototype
			</label>
			<label>
				<input type="radio" name="Poll" value="jquery" id="Poll_2" />
				jQuery
			</label>
			<label>
				<input type="radio" name="Poll" value="spry" id="Poll_3" />
				Spry
			</label>
			<label>
				<input type="radio" name="Poll" value="other" id="Poll_4" />
				Other
			</label>
			<input type="submit" name="submit" id="submit" value="Vote" />
			<input type="hidden" name="id" value="form1" />
			<input type="hidden" name="MM_insert" value="form1" />
		</form>
		</fieldset>
	-->
</body>
</html>