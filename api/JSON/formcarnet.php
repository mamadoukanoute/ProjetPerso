<form action="" method="post">
<table>
<tr>
<td>Prénom</td>
<td><input type="text" name="info"   value='<?php echo '{"prenom":"'.$t[0]['prenom'].'","datenaissance":"'.$t[0]['datenaissance'].'"}';?>' size="70";/></td>
</tr>



<?php

 //$taille=count($t2);
//print_r($t2);
for($i=0;$i<$taille;$i++){
	?>
	<tr><td><strong>Adresse <?php $number=$i+1;echo"$number"; ?></strong></td></tr>
	<tr>
<td>Rue</td>
<td><input type='text' name="<?php $adresse='adresse'.$i;echo $adresse; ?>" value='<?php echo '{"rue":"'.$t2[$i]['rue'].'","code":"'.$t2[$i]['codepostal'].'","ville":"'.$t2[$i]['ville'].'"}';?>'size="70"  /></td>
</tr>

<tr>
<td><input type='hidden' name="<?php $hidden='hidden'.$i;echo $hidden; ?>" value='<?php echo $t2[$i]['id'] ?>'size="70"  /></td>
</tr>


<?php

}

?>


<tr>
<td><input type="submit" name="modifier" value="Modifier" /></td>
</tr>
</table>
</form>