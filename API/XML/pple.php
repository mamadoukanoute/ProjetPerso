<?php
session_start();


if(isset($_SESSION['token'])){
	$token=$_SESSION['token'];
if($_SESSION['token']==$_GET["token"]){

echo"

<a href='api.php?action=get'>Lister les membres</a><br/>
<a href='api.php?action=post&token=$token'>Ajouter un membre</a><br/>
<a href='exporter.php'>Exporter mon carnet</a><br/>
<a href='microform.php'>importer mon carnet</a><br/>
<a href='../deconnexion.php'>Deconnexion</a><br/>

";
}else echo "bad token";
}else echo "connectez-vous pour accéder à cette partie";

?>