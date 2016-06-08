<?php
session_start();
require("../include/dbhandlerxml.php");

$userid=$_SESSION['userid'];

if(isset($_FILES['nomfichier'])){
	$hand=new Dbhandler();
	$nomfichier=$_FILES["nomfichier"]["name"];
$tmp=$_FILES["nomfichier"]["tmp_name"];
$courant=getcwd().'/uploads/'.$userid.'.xml';
$resultat=move_uploaded_file($tmp, $courant);
if($resultat){
chdir("uploads");
$fichier = $userid.'.xml';
$xml = simplexml_load_file($fichier);

foreach($xml as $personne){
	$hand->api_postCarnetxml2($personne->civilite,$personne->prenom,$personne->nom,$personne->datenaissance,$personne->cree,$personne->mis_a_jour);
	 plusieurselements($personne->adresse,$personne->nom);
}


}
}


function plusieurselements($adresse,$contactid){
$hand=new Dbhandler();
for($i=0;$i<count($adresse->rue);$i++){
$hand->api_postCarnetxml($contactid,$adresse->rue[$i],$adresse->codepostal[$i],$adresse->ville[$i],$adresse->cree[$i],$adresse->mis_a_jour[$i]);
}

}




?>