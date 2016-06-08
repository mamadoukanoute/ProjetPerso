<form action="" method="post">
<table>
<tr>
<?php
    foreach($xml as $personne){
}
?>
<td>Prénom</td>
<td><input type="text" name="prenom"   value='<?php echo $personne->prenom; ?>'/></td>
</tr>

<tr>
<td>Nom</td>
<td><input type="text" name="nom"   value='<?php echo $personne->nom; ?>'/></td>
</tr>


<tr>
<td>Date de naissance</td>
<td><input type="date" name="datenaissance"   value='<?php echo $personne->naissance; ?>'/></td>
</tr>


<?php

 $taille=count($t2);
//print_r($t2);
for($i=0;$i<$taille;$i++){
	?>
	<tr><td><strong>Adresse <?php $number=$i+1;echo"$number"; ?></strong></td></tr>
	<tr>
<td>Rue</td>
<td><input type='text' name="<?php $rue='rue'.$i;echo"$rue"; ?>" value="<?php echo $personne->rue  ?>" /></td>
</tr>

<tr>
<td>Code postal</td>
<td><input type='text' name="<?php $code='code'.$i;echo"$code"; ?>"  value='<?php echo $personne->codepostal  ?>'required/></td>
</tr>


<tr>
<td>ville</td>
<td><input type='text' name="<?php $ville='ville'.$i;echo"$ville"; ?>" value='<?php echo $personne->ville ?>'required /></td>
</tr>
<tr>
<td><input type='hidden' name="<?php $id='id'.$i;echo"$id"; ?>" value='<?php echo $personne->id  ?>'required /></td>
</tr>



<?php

}

?>


<tr>
<td><input type="submit" name="modifier" value="Modifier" /></td>
</tr>
</table>
</form>