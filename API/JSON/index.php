<?php
echo"
<a href='api.php?action=get'>Lister les membres</a><br/>
<a href='api.php?action=post'>Ajouter un membre</a><br/>
<a href='>Exporter au format JSON</a><br/>
<a href='{{ path('fos_user_profile_show') }}'>S'inscrire</a><br/>

<a href='loginform.php'>Se connecter</a><br/>
 
";
?>