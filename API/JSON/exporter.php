<?php
session_start();
require("../include/dbhandlerjson.php");

chdir ("uploads");
$hand=new Dbhandler();
$bool=false;
if($bool==false){
$list=$hand->api_getcarnet();
$userid=$_SESSION['userid'];
$nom=$userid.'.json';
    $fp = fopen($nom, 'w+');
    fwrite($fp, $list);
    fclose($fp);
    $bool=true;
}
    if($bool==true){
    	
echo"

 <tr>
<td><a href='uploads/$nom' download='moncarnet.json'>Télécharger le carnet au format json
</a></td></tr>
";
}

?>