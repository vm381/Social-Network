<?php

	require_once("User.php");
	require_once("../db/MessageDbUtil.php");

	class Message {

		private $user;
		private $message_id;
		private $message_text;

		public function __construct($user, $message_text) {
			$this->user = $user;
			$this->message_text = $message_text;
		}

		public function getUser() {
			return $this->user;
		} 

		public function getMessageID() {
			return $this->message_id;
		}

		public function getMessageText() {
			return $this->message_text;
		}

		public function post() {
			$mes = new MessageDbUtil();
			return $mes->saveMessage(null, $this->message_text);
		}

		public function getHTML() {
			return "
				<div> 
					<span> Username </span> <br>
					<span> {$this->message_text} </span>
				</div>
			";
		}
	}

?>