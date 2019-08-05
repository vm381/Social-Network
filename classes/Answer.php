<?php

/**
* 
*/
require_once ("../db/QuizDbUtil.php");

class Answer 
{

	
    	public function getAnswers($ansid){
        	try {
            	$sql = "SELECT * FROM answer WHERE aid "."=:id";
            	$st = $this->conn->prepare($sql);
            	$st->bindValue("id", $ansId, PDO::PARAM_INT);
            	$st->execute();
            	return $st->fetchAll();
        	} catch (PDOException $e) {
            	return array();
        	}
    	}
    	

    	
    	/*
		
       <?php
		
		?>

    	*/
}
?>