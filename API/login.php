<?php
session_start();
//On génére un jeton totalement unique (c'est capital :D)
//$token = uniqid(rand(), true);
$jeton = md5(uniqid(rand(), TRUE)); //création d'un jeton
$utilisateur = md5('.$pseudo_membre'.md5("graindesel")); //On hash le nom d'utilisateur
$token = "$utilisateur:$jeton";
//Et on le stocke
$_SESSION['token'] = $token;

//On enregistre aussi le timestamp correspondant au moment de la création du token
$_SESSION['token_time'] = time();
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
echo"
<a href='JSON/pple.php?token=$token'>API en JSON</a><br/>
<a href='XML/pple.php?token=$token'>API en XML</a><br/>
";
    }else{
echo "erreur ";
include("loginform.php");

    }
    



?>