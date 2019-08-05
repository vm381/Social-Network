<?php
  class ChatDbUtil {

    private $conn;

    public function __construct($configFile = "config.ini") {
      if ($config = parse_ini_file($configFile)) {
        $host = $config["host"];
        $database = $config["database"];
        $user = $config["user"];
        $password = $config["password"];
        $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
    }

    public function __destruct() {
      $this->conn = null;
    }

    public function getMessages($user1, $user2) {
      $sql = "select * from Message where (User_sender = :user1 and User_receiver = :user2) or (User_sender = :user2 and User_receiver = :user1)";
      $st = $this->conn->prepare($sql);
      $st->bindValue("user1", $user1, PDO::PARAM_STR);
      $st->bindValue("user2", $user2, PDO::PARAM_STR);

      $st->execute();
      return $st->fetchAll();
    }

    public function addMessage($text, $time, $sender, $receiver) {
      $sql = "insert into Message (text, time, User_sender, User_receiver) values (:text, :time, :sender, :receiver)";
      $st = $this->conn->prepare($sql);
      $st->bindValue("text", $text, PDO::PARAM_STR);
      $st->bindValue("time", $time, PDO::PARAM_STR);
      $st->bindValue("sender", $sender, PDO::PARAM_STR);
      $st->bindValue("receiver", $receiver, PDO::PARAM_STR);

      return $st->execute();
    }

  }
?>
