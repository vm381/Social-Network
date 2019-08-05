<?php
  require_once("../classes/Post.php");
  require_once("../classes/Zid.php");
  require_once("../db/PostsDbUtil.php");
  require_once("../db/UserDbUtil.php");

  session_start();

  if (!isset($_SESSION["username"])) {
    header("Location: login_form.php");
  }

  if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    session_destroy();
    setcookie("otheruser", "", time() - 3600, "/");
    header("Location: login_form.php");
  }

  $zid = new Zid($_SESSION["username"]);
  $postdbutil = new PostsDbUtil();
  $userdbutil = new UserDbUtil();

  if (isset($_GET["like"])) {
    $idPost = htmlspecialchars($_GET["like"]);
    $post = $postdbutil->getPostById($idPost);
    if ($post) {
      $post->like();
      header("Location: pocetna.php");
    }
  }

  $zid->sortPostsByTime();

  if (isset($_POST["sort"])) {
    if ($_POST["criteria"] == "date") {
      $zid->sortPostsByTime();
      $_SESSION["sortCriteria"] = htmlspecialchars($_POST["criteria"]);
    }
    if ($_POST["criteria"] == "popularity") {
      $zid->sortByLikes();
      $_SESSION["sortCriteria"] = htmlspecialchars($_POST["criteria"]);
    }
  }

  if (isset($_SESSION["sortCriteria"])) {
    if ($_SESSION["sortCriteria"] == "date") {
      $zid->sortPostsByTime();
    }
    if ($_SESSION["sortCriteria"] == "popularity") {
      $zid->sortByLikes();
    }
  }
?>
<?php include("header.php"); ?>
<center>
  <div style="margin-left: 300px;">
<?php
  $loggedUser = $userdbutil->findUserByUsername($_SESSION["username"]);
  echo "<h2>Welcome, {$loggedUser["first_name"]} {$loggedUser["last_name"]}!</h2>\n";
 ?>
  <form action="pocetna.php" method="post">
    <textarea rows="4" cols="50" name="sadrzaj"></textarea>
    <br>
    <input type="submit" name="objavi" value="Objavi">
  </form>
  <br>

  <form action="pocetna.php" method="post">
    <label>Sortiraj po: </label>
    <select name="criteria">
      <option value="date" <?php if (isset($_SESSION["sortCriteria"]) && $_SESSION["sortCriteria"] == "date") echo "selected"; ?>>Datum</option>
      <option value="popularity" <?php if (isset($_SESSION["sortCriteria"]) && $_SESSION["sortCriteria"] == "popularity") echo "selected"; ?>>Popularnost</option>
    </select>
    <input type="submit" name="sort" value="Sortiraj">
  </form>
  <br>
<?php
  if (isset($_POST["objavi"])) {
    $post = new Post(rand(0, 1000),$_SESSION["username"], htmlspecialchars($_POST["sadrzaj"]), date("Y-m-d H:i:s"));
    $postdbutil->addPost($post);
  }

  $posts = $zid->getPosts();
  if (!empty($posts)) {
    echo "<hr>\n";
    foreach ($posts as $p) {
      echo $p->getHtml() . "\n";
      echo "
        <div>
          <span>
            <a href=\"pocetna.php?like={$p->getId()}\"><button>Like ({$p->getLikes()})</button></a>
            </span>
            </div>
            ";
      echo "<hr>\n";
    }
  }
 ?>
 </div>
 <div style="height: 100%; width: 300px; position: fixed; z-index: 1;">
   <?php
    $pages = $userdbutil->getUsersPages($_SESSION["username"]);

    if (!empty($pages)) {
      echo "<h3>Stranice: </h3>";
    }

    foreach ($pages as $page) {
    ?>
      <a href="PageShow.php?id=<?php echo $page["idPage"]; ?>"><?php echo $page["name"] ?></a><br>
    <?php
    }
    ?>
 </div>
  </center>
<?php include("footer.php"); ?>
