<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{ asset('bundles/framework/css/style.css') }}" type="text/css"media="all" />
</head>
<body>
<?

?>

<h3>Liste </h3>
<div class="well">

<table>

<tr>
<td><?php echo $resultat; ?></td>
<td><?php $t=json_decode($resultat,true);
//$carnetid=$t[0]['id'];
//echo $t[0]['datenaissance']; ?><br/></td></tr>

<tr><td><strong>ADRESSE<strong></td></tr>
<tr>
<td><?php 
echo $resultat2;
/*$t=json_decode($resultat2,true);
 $taille=count($t);*/




?>

</tr>
<?php
if($token!=""&&$resultat!=null){
	$token=$_SESSION['token'];
echo"
<tr><td><a href='api.php?action=put&token=$token&value=$id '>Modifier les infos</a></td>
<tr><td><a href='api.php?action=postadr&token=$token&value=$value'>Ajouter d'autres adresses</a></td>

<tr><td><a href='api.php?action=delete&token=$token&value=$id '>✘</a></td>";

}
?>




</table>
</div>
</body>
</html>