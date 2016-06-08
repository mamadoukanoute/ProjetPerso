<?php
session_start();
require("../include/dbhandlerjson.php");

$userid=$_SESSION['userid'];
if(isset($_FILES['nomfichier'])){
$hand=new Dbhandler();
	$nomfichier=$_FILES["nomfichier"]["name"];
$tmp=$_FILES["nomfichier"]["tmp_name"];
$courant=getcwd().'/uploads/'.$userid.'.json';
$resultat=move_uploaded_file($tmp, $courant);
if($resultat){
chdir("uploads");
$json = file_get_contents($userid.'.json');
$obj = json_decode($json,true);
$taille=count($obj);
for($i=0;$i<$taille;$i++){

$obj1 = json_decode($obj[$i]['adresse'],true);
$hand->api_postCarnetjson2('ddd',$obj[$i]['prenom'],$obj[$i]['nom'],$obj[$i]['datenaissance'],$obj[$i]['cree'],$obj[$i]['mis_a_jour']);
plusieurselements($obj1,$obj[$i]['nom']);

}

}
}
function plusieurselements($adresse,$contactid){
$hand=new Dbhandler();
for($i=0;$i<count($adresse);$i++){
$hand->api_postCarnetjson($contactid,$adresse[$i]['rue'],$adresse[$i]['codepostal'],$adresse[$i]['ville'],
	$adresse[$i]['cree'],$adresse[$i]['mis_a_jour']);
}

}




?>