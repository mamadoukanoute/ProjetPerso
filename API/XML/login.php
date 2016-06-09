<?php
session_start();
require("include/dbconnect.php");
 $db = new DbConnect();
       $conn = $db->connect();
 $username=$_POST['username'];
    $motdepasse=$_POST['motdepasse'];     
$sql = "SELECT*FROM user WHERE username='$username' AND motdepasse='$motdepasse'";
$result = mysqli_query($conn, $sql);

$data=array();
if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$token = uniqid(rand(), true);
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
$_SESSION['motdepasse'] = $motdepasse;
$_SESSION['username'] = $username;
$_SESSION['userid']=$row['id'];

echo $_SESSION['userid'];
include("pple.php");

    }else{
echo "erreur ";
include("loginform.php");

    }
    



?>