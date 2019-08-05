<?php
	/**
	* 
	*/
	require_once ("../db/QuizDbUtil.php");
	$db=new QuizDbUtil("config1.ini");
	class Question 
	{
		

		public function getQuestions(){

			//$array=getQuestions($num);

			for ($i=0; $i <10 ; $i++) { 			
				$array=$db->getQuestions($i);
				$arraya=array($array);
				
			/*foreach( $array as $row ) {
		    	echo $row["figure"];
			}*/
			}
			return $arraya;
		}
		

		/*public function getAnswers()
		{
			$array=array();
			$array=getAnswers($num);
			return $array;
		}*/
	}
?>