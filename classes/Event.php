<?php

class Event{
    private $id;
	private $name;
	private $date;
	private $time;
    private $category;

	public function __construct($id,$name,$date,$time,$category) {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->time = $time;
        $this->category = $category;
    }
    //---------------------- GETTERS ----------------------
    public function getId(){
    	return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function  getDate(){
    	return $this->date;
    }
    public function  getTime(){
    	return $this->time;
    }
    public function  getCategory(){
        return $this->category;
    }
    //---------------------- SETTERS ----------------------
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
    	$this->name = $name;
    }
    public function  setDate($date){
    	$this->date = $date;
    }
    public function  setTime($time){
    	$this->time = $time;
    }
    public function  setCategory($category){
        $this->category = $category;
    }
}