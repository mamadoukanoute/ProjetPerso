<?php
session_start();
require("../include/dbhandlerxml.php");

chdir ("uploads");
$hand=new Dbhandler();
$bool=false;
if($bool==false){
$list=$hand->api_getcarnet();
$userid=$_SESSION['userid'];
$nom=$userid.'.xml';
//echo $list;
    $fp = fopen($nom, 'w+');
    fwrite($fp, $list);
    fclose($fp);
    $bool=true;
}
    if($bool==true){
echo"

 <tr>
<td><a href='uploads/$nom' download='moncarnet.xml'>Télécharger le carnet au format xml
</a></td></tr>
";
}

?>