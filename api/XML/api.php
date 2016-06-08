<?php
session_start();
include("../include/dbhandlerxml.php");
    	$dbhandler=new Dbhandler();

if ((isset($_GET["action"])))
  {
  switch ($_GET["action"])
    {
    case ("get"):
    if(isset($_GET["value"])){

    	$resultat=$dbhandler->api_getcarnetdetail($_GET["value"]);
    	$id=$_GET["value"];
    	
    	    	$resultat2=$dbhandler->api_getcarnetdetail2($id);
    		include("afficher.php");
        break;
    }else
      $resultat=$dbhandler->api_getcarnet();
      echo $resultat;
      break;

     case ("post"):
      if($_SESSION['token']==$_GET["token"]){
     if(!isset($_POST['ajouter'])) {
     	include("add.php");
     }else

     $dbhandler->api_postcarnet();
}else echo "bad token";
     break;

     case ("put"):
      if($_SESSION['token']==$_GET["token"]){
     if(!isset($_POST['modifier'])&&isset($_GET["value"])) {
     	$resulat= $dbhandler->api_getcarnetdetail($_GET["value"]);
     // $resulat2=$dbhandler->api_getcarnetdetail3($_GET["value"]);
      //var_dump($resulat);
      $xml=simplexml_load_string($resulat);
      /*$xml2=simplexml_load_string($resulat2);
      echo count($xml2);*/
    
 
    //include("formcarnet.php");
     }if(isset($_POST['modifier'])) {
     		$dbhandler->api_putCarnet($_GET["value"]);
     }
   }else echo "bad token";

     break;

 case ("delete"):

if(isset($_GET["value"])) {
      if(!isset($_GET["token"])){
      echo "connectez-vous";
        include("../loginform.php");
      } if($_SESSION['token']==$_GET["token"]){
        $dbhandler->api_deleteCarnet($_GET["value"]);
      }else echo "bad token";
     }else echo "j'attends le nom de la personne à supprimer";
   break;

	default:
      print("L'action appelée n'existe pas.");  
	}
  }

  ?>