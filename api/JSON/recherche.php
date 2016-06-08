<?php
session_start();
  $token=$_SESSION['token'];
$search=$_POST['search'];
$test='http://localhost/API/JSON/api.php?action=get&'.'token='.urlencode($token).'&value='.urlencode($search).'';
  header('Location: '.$test.'');

?>