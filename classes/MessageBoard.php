<?php

	require_once("../db/MessageDbUtil.php");

	class MessageBoard {

		private $discussions;
		private $msgdbutil;

		public function __construct() {
			$this->discussions = array();
			$this->msgdbutil = new MessageDbUtil();
			$this->discussions = $this->msgdbutil->getDiscussions();
		}

		public function getDiscussions() {
			return $this->discussions;
		}

		public function createDiscussion($title, $post) {
			$this->msgdbutil->createDiscussion($title, $post);
		}
	}

?>