<?php
require("include/dbhandlerjson.php");
$hand=new Dbhandler();
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])){
$hand->utilisateur($_POST['username'],$_POST['password'],$_POST['email']);

}



?>