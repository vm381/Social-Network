<?php
  require_once("../db/PostsDbUtil.php");
  require_once("../db/UserDbUtil.php");
  require_once("../classes/Post.php");

  class Zid {

    private $user;
    private $posts;

    public function __construct($username) {
      $this->user = $username;
      $posts = [];
      $this->getFriendsPosts();
    }

    public function getUsername() {
      return $this->user;
    }

    public function getPosts() {
      return $this->posts;
    }

    private function getFriendsPosts() {
      $userdbutil = new UserDbUtil();
      $postdbutil = new PostsDbUtil();
      $friends = $userdbutil->getUsersFriends($this->user);

      foreach ($friends as $friend) {
        $posts = $postdbutil->getUsersPosts($friend["User_username1"]);
        foreach ($posts as $post) {
          $userPost = new Post($post["idPost"], $post["User_username"], $post["text"], $post["time"], $post["likes"]);
          $this->posts[] = $userPost;
        }
      }
    }

    public function sortPostsByTime() {
      for ($i = 0; $i < count($this->posts) - 1; $i++) {
        $max = $i;
        for ($j = $i + 1; $j < count($this->posts); $j++) {
          if (strtotime($this->posts[$j]->getTime()) > strtotime($this->posts[$max]->getTime())) {
            $max = $j;
          }
        }

        $tmp = $this->posts[$i];
        $this->posts[$i] = $this->posts[$max];
        $this->posts[$max] = $tmp;
      }
    }

    public function sortByLikes() {
      for ($i = 0; $i < count($this->posts) - 1; $i++) {
        $max = $i;
        for ($j = $i + 1; $j < count($this->posts); $j++) {
          if ($this->posts[$j]->getLikes() > $this->posts[$max]->getLikes()) {
            $max = $j;
          }
        }

        $tmp = $this->posts[$i];
        $this->posts[$i] = $this->posts[$max];
        $this->posts[$max] = $tmp;
      }
    }

  }
 ?>
