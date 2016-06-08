<?php
session_start();


if(isset($_SESSION['token'])){
	$token=$_SESSION['token'];
if($_SESSION['token']==$_GET["token"]){
echo"
<a href='api.php?action=get&token=$token'>Lister les membres</a><br/>
<a href='api.php?action=post&token=$token'>Ajouter un membre</a><br/>
<td>Rechercher un membre en particulier avec son nom</td>";?>
<form action='recherche.php' method='post'>
<td><input type='search' name='search'  placeholder='Nom' required/></td>
<td><input type='submit' name='rechercher'  value='Rechercher'  /></td>
</tr><br/>
</form>
<?php echo"<a href='exporter.php'>Exporter mon carnet</a><br/>
<a href='microform.php'>Importer mon carnet au format json</a><br/>
<a href='../deconnexion.php'>Déconnexion</a><br/>

";
}else echo "bad token";
}else echo "connectez-vous pour accéder à cette partie";

?>