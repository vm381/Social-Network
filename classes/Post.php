<?php

  require_once("../db/UserDbUtil.php");
  require_once("../db/PostsDbUtil.php");

  class Post {

    private $post_id;
    private $user;
    private $text;

    private $time;
    private $likes;

    private $comments;

    public function __construct($post_id, $user, $text, $time, $likes = 0, $comments = []) {
      $this->post_id = $post_id;
      $this->user = $user;
      $this->text = $text;
      $this->time = $time;
      $this->likes = $likes;
      $this->comments = $comments;
    }

    public function getId() {
      return $this->post_id;
    }

    public function getUser() {
      return $this->user;
    }

    public function getText() {
      return $this->text;
    }

    public function getTime() {
      return $this->time;
    }

    public function getLikes() {
      return $this->likes;
    }

    public function like() {
      $this->likes++;
      $dbutil = new PostsDbUtil();
      $dbutil->updateLikes($this->getId(), $this->getLikes());
    }

    public function getHtml() {
      $user = new UserDbUtil();
      $user = $user->findUserByUsername($this->user);

      $html = "
        <div>
          <a href=\"profil.php?username1={$user["username"]}\">
            <span>{$user["first_name"]} {$user["last_name"]}</span>
          </a>
          <br>
          <span>{$this->getText()}</span>
          <br>
          <span> {$this->getTime()} </span>
          <br>
        </div>
      ";

      return $html;
    }

  }
 ?>
