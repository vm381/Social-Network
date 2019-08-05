<?php
session_start();

if (!isset($_SESSION["username"])) {
  header("Location: login_form.php");
}

if (isset($_GET["download"])) {
  $file = "../db/files/{$_SESSION["username"]}/{$_GET["download"]}";
  if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
  }
}
?>
