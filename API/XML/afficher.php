<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{ asset('bundles/framework/css/style.css') }}" type="text/css"media="all" />
</head>
<body>


<h3>Liste </h3>
<div class="well">

<table>

<tr>
<td><?php echo $resultat; ?></td>




<tr><td>ADRESSE</td></tr>
<tr>
<td><?php echo $resultat2; ?></td>
</tr>
<?php
echo"
<tr><td><a href='api.php?action=delete&value=$id '>✘</a></td>";
?>





</table>
</div>
</body>
</html>