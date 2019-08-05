<?php

	require_once("User.php");
	require_once("../db/UserDbUtil.php");

	class Login {

		public function signin($username, $password) {
			$dbutil = new UserDbUtil();
			$user = $dbutil->findUser($username, $password);

			if($user) {
				return $user;
			} else {
				return false;
			}
		}
	}
?>