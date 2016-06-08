<?php
session_start();
include("../include/dbhandlerjson.php");
    	$dbhandler=new Dbhandler();

if ((isset($_GET["action"])))
  {
  switch ($_GET["action"])
    {
    case ("get"):
    $token="";
  if(isset($_GET["token"])){
      $token=$_GET["token"];
      }
     // else{*/
    if(isset($_GET["value"])){
$value=$_GET["value"];
    	$resultat=$dbhandler->api_getcarnetdetail($_GET["value"]);

    	$id=$_GET["value"];
    	    	$resultat2=$dbhandler->api_getcarnetdetail2($id);
    		include("afficher.php");
              break;

    }else
      $resultat=$dbhandler->api_getcarnet();
      //echo $resultat;
      //include("all.php");
      $test1=json_decode($resultat,true);
      $taille= count($test1);
      include("all.php");

      //print_r(json_encode($test1[0]));
   // }
      break;

     case ("post"):

      if(!isset($_GET["token"])){
      echo "connectez-vous d'abord";
        include("../loginform.php");
      }else{
if($_SESSION['token']==$_GET["token"]){
     if(!isset($_POST['ajouter'])) {
     	include("add.php");
     }else

     $dbhandler->api_postcarnet();
   }else echo "bad token";
}
     break;




     case ("postadr"):

      if(!isset($_GET["token"])){
      echo "connectez-vous";
        include("loginform.php");
      }else{
        if($_SESSION['token']==$_GET["token"]){

     if(!isset($_POST['ajouter'])) {
      include("ajouter.php");
     }else

     $dbhandler->api_postadresse($_GET["value"]);
}else echo "bad token";
}

     break;

     case ("put"):

   

         if(!isset($_GET["token"])){
      echo "connectez-vous";
        include("loginform");
      }
      else{
      
              if($_SESSION['token']==$_GET["token"]){
                 // $taille=0;
     if(!isset($_POST['modifier'])&&isset($_GET["value"])) {


     $resulat=$dbhandler->api_getcarnetdetail($_GET["value"]);
      $t=json_decode($resulat,true);//echo $t[0]['datenaissance'];
     
      $resultat2=$dbhandler->api_getcarnetdetail2($t[0]['nom']);
        $t2=json_decode($resultat2,true);
        $taille= count($t2)."<br/>";
       // print_r(json_encode($t2[0]));
        // print_r($t2[1]);
//echo $t2;
     	include("formcarnet.php");
}
     if(isset($_POST['modifier'])) {
$resulat=$dbhandler->api_getcarnetdetail($_GET["value"]);
      $t=json_decode($resulat,true);//echo $t[0]['datenaissance'];
     
      $resultat2=$dbhandler->api_getcarnetdetail2($t[0]['nom']);
        $t2=json_decode($resultat2,true);
        $taille= count($t2)."<br/>";
     		$dbhandler->api_putCarnet($_GET["value"],$taille);
   }
   
 }else echo"bad token";
}
     break;

 case ("delete"):

     if(isset($_GET["value"])) {
      if(!isset($_GET["token"])){
      echo "connectez-vous";
        include("../loginform.php");
      }else 
       if($_SESSION['token']==$_GET["token"]){
     		$dbhandler->api_deleteCarnet($_GET["value"]);
      }else echo "bad token";
     }else echo "j'attends le nom de la personne à supprimer";
   break;

	default:
      print("L'action appelée n'existe pas.");  
	}
  }

  ?>