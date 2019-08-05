<?php

	require_once("Post.php");
	require_once("../db/UserDbUtil.php");

	class User {

		private $first_name;
		private $last_name;
		private $username;
		private $password_1;
		private $password_2;
		private $birthday;
		private $gender;
		private $city;
		private $school;


		public function __construct($first_name, $last_name, $username, $password_1, $password_2, $birthday, $gender, $city, $school) {
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->username = $username;
			$this->password_1 = $password_1;
			$this->password_2 = $password_2;
			$this->birthday = $birthday;
			$this->gender = $gender;
			$this->posts = array();

			$this->city = $city;
			$this->school = $school;

		}
		public function setFirstName($novoIme){
			$this->first_name=$novoIme;
		}
		public function setLastName($novoPrezime){
			$this->last_name=$novoPrezime;
		}
		public function getFirstName() {
			return $this->first_name;
		}

		public function getLastName() {
			return $this->last_name;
		}

		public function getUsername() {
			return $this->username;
		}

		public function getPassword1() {
			return $this->password_1;
		}

		public function getPassword2() {
			return $this->password_2;
		}

		public function getBirthday() {
			return $this->birthday;
		}

		public function getGender() {
			return $this->gender;
		}

		public function getPosts() {
			return $this->posts;
		}

		public function getSchool() {
			return $this->school;
		}

		public function getCity() {
			return $this->city;
		}

		public function registration() {
			if($this->password_1 != $this->password_2) {
				return false;
			}

			$dbutil = new UserDbUtil();
			$user = $dbutil->saveUser($this->username, $this->password_1, $this->first_name, $this->last_name, $this->city, $this->school, $this->birthday, $this->gender);
			if($user) {
				return true;
			} else {
				return false;
			}
		}

	}

?>
