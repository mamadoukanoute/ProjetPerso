<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{ asset('bundles/framework/css/style.css') }}" type="text/css"media="all" />
</head>
<body>


<h3>Liste </h3>
<div class="well">

<table>
<?php
for($i=0;$i<$taille;$i++){

print_r(json_encode($test1[$i]));echo"<br/><br/>";

}

?>




</table>
</div>
</body>
</html>