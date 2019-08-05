<?php include("header.php"); ?>
<?php
require_once("../db/UserDbUtil.php");
require_once("../db/ChatDbUtil.php");
require_once("../classes/ChatMessage.php");

session_start();

if (!isset($_SESSION["username"])) {
  header("Location: login_form.php");
}

if (isset($_GET["user"])) {
  setcookie("otheruser", $_GET["user"], time() + (60 * 60 * 24 * 7), "/");
  header("Location: inbox.php");
}
?>

<div style="height: 100%; width=200px; position: fixed; z-index: 1;">
  <?php

  $userdbutil = new UserDbUtil();
  $chatdbutil = new ChatDbUtil();

  $loggedUser = $userdbutil->findUserByUsername($_SESSION["username"]);

  $friends = $userdbutil->getUsersFriends(htmlspecialchars($_SESSION["username"]));

  echo "<hr>\n";
  foreach ($friends as $friend) {
    $user = $userdbutil->findUserByUsername($friend["User_username1"]);
    echo "
    <a href=\"inbox.php?user={$user["username"]}\"><span>{$user["first_name"]} {$user["last_name"]}<span></a><br>
    ";
    echo "<hr>\n";
  }
  ?>
</div>
<div style="margin-left: 200px;">
  <center>
    <?php
    if (isset($_COOKIE["otheruser"])) {
      $user1 = $_SESSION["username"];
      $user2 = $_COOKIE["otheruser"];

      if (isset($_POST["sendMessage"])) {
        $text = htmlspecialchars($_POST["messageText"]);
        $newMessage = new ChatMessage($text, date("Y-m-d H:i:s"), $user1, $user2);
        $newMessage->send();
        $newMessage->uploadFile();
      }

      $otherUser = $userdbutil->findUserByUsername($user2);

      $messages = $chatdbutil->getMessages($user1, $user2);
      $messages = sortMessages($messages);

      foreach ($messages as $msg) {
        $html = "";
        if ($msg["User_sender"] == $user1) {
          $html .= "<a href=\"profil.php\"";
          $html .= "<span>";
          $html .= $loggedUser["first_name"] . " " . $loggedUser["last_name"];
        }
        if ($msg["User_sender"] == $user2) {
          $html .= "<a href=\"profil.php?username1={$otherUser["username"]}\"";
          $html .= "<span>";
          $html .= $otherUser["first_name"] . " " . $otherUser["last_name"];
        }
        $html .= "</span>";
        $html .= "</a>\n";
        $html .= "<span>{$msg["time"]}</span>\n";
        $html .= "<br>";
        $html .= "<div>{$msg["text"]}</div>";
        $html .= "<br>\n";

        echo $html;
      }

      ?>
      <br>
      <form action="inbox.php" method="post" enctype="multipart/form-data">
        <textarea rows="4" cols="50" name="messageText"></textarea>
        <br>
        <label>Send a file: </label>
        <input type="file" name="file">
        <br>
        <input type="submit" name="sendMessage" value="Posalji">
      </form>
      <br>
      <?php
    }
    ?>
    <div>
      <?php
      if (file_exists("../db/files/" . $_SESSION["username"])) {
        $dir = opendir("../db/files/" . $_SESSION["username"] . "/");
        if ($dir) {
          while ($fileName = readdir($dir)) {
            echo "<a href=\"download_file.php?download=$fileName\">$fileName</a><br>";
          }
        }
      }
      ?>
    </div>
  </center>
</div>

<?php
function sortMessages($messages) {
  for ($i = 0; $i < count($messages) - 1; $i++) {
    $min = $i;
    for ($j = 1; $j < count($messages); $j++) {
      if (strtotime($messages[$j]["time"]) < strtotime($messages[$min]["time"])) {
        $min = $j;
      }
    }
    $tmp = $messages[$i];
    $messages[$i] = $messages[$min];
    $messages[$min] = $tmp;
  }

  return $messages;
}
?>
<?php include("footer.php"); ?>
