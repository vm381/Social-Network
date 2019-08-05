<?php
  require_once("../db/ChatDbUtil.php");

  class ChatMessage {

    private $text;
    private $time;
    private $sender;
    private $receiver;

    public function __construct($text, $time, $sender, $receiver) {
      $this->text = $text;
      $this->time = $time;
      $this->sender = $sender;
      $this->receiver = $receiver;
    }

    public function getId() {
      return $this->id;
    }

    public function getText() {
      return $this->text;
    }

    public function getTime() {
      return $this->time;
    }

    public function getSender() {
      return $this->sender;
    }

    public function getReceiver() {
      return $this->receiver;
    }

    public function send() {
      $dbutil = new ChatDbUtil();
      $dbutil->addMessage($this->getText(), $this->getTime(), $this->getSender(), $this->getReceiver());
    }

    public function uploadFile() {
      if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
        if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
          if (!file_exists("../db/files/{$this->getReceiver()}")) {
            mkdir("../db/files/{$this->getReceiver()}", 0777);
          }
          move_uploaded_file($_FILES["file"]["tmp_name"], "../db/files/" . $this->getReceiver() . "/" . basename($_FILES["file"]["name"]));
        }
      }
    }

  }
 ?>
