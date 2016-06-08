<?php
 
/**
 * Classe pour gérer toutes les opérations de db
 * Cette classe aura les méthodes CRUD pour les tables de base de données
 *
 
 */
class Dbhandler {
    private $conn;
       private  $xml;
    private $ajouter;
    private $carnet;
    function __construct() {
        require_once dirname(__FILE__) . '/dbconnect.php';
        //Ouverture connexion db
        $db = new DbConnect();
        $this->conn = $db->connect();

    }
    


  

    function api_getcarnet()
    {
                        $this->xml = new DOMDocument('1.0', 'utf-8');

  $xml=$this->xml;
        //$nouveauPays = $dom->createElement("pays");
$sql = "SELECT*FROM contacts";
$result = mysqli_query($this->conn, $sql);
$carnets=$xml->createElement("carnets");
$xml->appendChild($carnets);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    	$i=1;
    	//$h='carnet'.$i;
    	 $this->carnet = $xml->createElement("carnet");
    	 $carnet= $this->carnet;
          $xml->appendChild($carnet);
           $tag = $xml->createElement('id',$row['id']);
          $carnet->appendChild($tag);
           $tag = $xml->createElement('civilite',$row['civilite']);
          $carnet->appendChild($tag);
       $tag = $xml->createElement('prenom',$row['prenom']);
          $carnet->appendChild($tag);
        $tag = $xml->createElement('nom',$row['nom']);
   $carnet->appendChild($tag);
          $tag = $xml->createElement('datenaissance',$row['naissance']);
          $carnet->appendChild($tag);
                   // echo"ddddddddddddddddddddd";

        $tag = $xml->createElement('cree',$row['cree']);
   $carnet->appendChild($tag);
          $tag = $xml->createElement('mis_a_jour',$row['mis_a_jour']);
          $carnet->appendChild($tag);
          $this->ajouter = $xml->createElement('adresse');
          $this->api_getcarnetdetail2($row['nom']);
   $carnets->appendChild($carnet);
        //echo $tab['prenom'];
      }
       return $xml->saveXML();
  // echo json_encode($data);
    }
}

    function api_getcarnetdetail($id)
    {
                              $this->xml = new DOMDocument('1.0', 'utf-8');

       $xml=$this->xml;
      //$xml = new DOMDocument('1.0', 'utf-8');
$sql = "SELECT*FROM contacts WHERE nom='$id'";
$result = mysqli_query($this->conn, $sql);
$carnets=$xml->createElement("carnets");
$xml->appendChild($carnets);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $i=1;
      //$h='carnet'.$i;
       $this->carnet = $xml->createElement("carnet");
       $carnet= $this->carnet;
          $xml->appendChild($carnet);
           $tag = $xml->createElement('id',$row['id']);
          $carnet->appendChild($tag);
           $tag = $xml->createElement('civilite',$row['civilite']);
          $carnet->appendChild($tag);
       $tag = $xml->createElement('prenom',$row['prenom']);
          $carnet->appendChild($tag);
        $tag = $xml->createElement('nom',$row['nom']);
   $carnet->appendChild($tag);
          $tag = $xml->createElement('datenaissance',$row['naissance']);
          $carnet->appendChild($tag);
                   // echo"ddddddddddddddddddddd";

        $tag = $xml->createElement('cree',$row['cree']);
   $carnet->appendChild($tag);
          $tag = $xml->createElement('mis_a_jour',$row['mis_a_jour']);
          $carnet->appendChild($tag);
          $this->ajouter = $xml->createElement('adresse');
          $this->api_getcarnetdetail2($row['id']);
   $carnets->appendChild($carnet);
        //echo $tab['prenom'];
      }
       return $xml->saveXML();
  // echo json_encode($data);
    }
}

    function api_getcarnetdetail2($id)
    {
      //$xml = new DOMDocument('1.0', 'utf-8');
$sql = "SELECT*FROM adresses WHERE contactid='$id'";
$result = mysqli_query($this->conn, $sql);
$this->carnet->appendChild($this->ajouter);
//$data=array();
if (mysqli_num_rows($result) > 0) {
	
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $tag = $this->xml->createElement('rue',$row['rue']);
          $this->ajouter->appendChild($tag);
        $tag = $this->xml->createElement('codepostal',$row['code_postal']);
   $this->ajouter->appendChild($tag);
   $tag = $this->xml->createElement('ville',$row['ville']);
          $this->ajouter->appendChild($tag);
            $tag = $this->xml->createElement('cree',$row['cree']);
   $this->ajouter->appendChild($tag);
          $tag = $this->xml->createElement('mis_a_jour',$row['mis_a_jour']);
          $this->ajouter->appendChild($tag);
      }
       //return $xml->saveXML();
     //echo json_encode($data);
    }
    
}







  public function api_postCarnet()
    {

$info=$_POST['info'];
$test=$info."";


$xml = simplexml_load_string($test);

foreach($xml as $personne){
  $this->api_postCarnetxml2($personne->civilite,$personne->prenom,$personne->nom,$personne->datenaissance,$personne->cree,$personne->mis_a_jour);
   $this->plusieurselements($personne->adresse,$personne->nom);
}


}






function plusieurselements($adresse,$contactid){
for($i=0;$i<count($adresse->rue);$i++){
$this->api_postCarnetxml($contactid,$adresse->rue[$i],$adresse->codepostal[$i],$adresse->ville[$i],$adresse->cree[$i],$adresse->mis_a_jour[$i]);
}

}




 public function api_postCarnetxml2($civilite,$prenom,$nom,$datenaissance,$cree,$mis_a_jour)
    {

$iduser=$_SESSION['userid'];

 $stmt1 = "INSERT INTO contacts(iduser,civilite,prenom, nom,naissance,cree,mis_a_jour ) VALUES ('$iduser','$civilite','$prenom','$nom','$datenaissance','$cree','$mis_a_jour')";


if (mysqli_query($this->conn, $stmt1)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt1 . "<br>" . mysqli_error($this->conn);
}
}

public function api_postCarnetxml($contactid,$rue,$code_postal,$ville,$cree,$mis_a_jour)
    {

 
$stmt2 = "INSERT INTO adresses (contactid, rue,code_postal, ville,cree,mis_a_jour ) VALUES ('$contactid','$rue',
'$code_postal','$ville','$cree','$mis_a_jour')";
   

if (mysqli_query($this->conn, $stmt2)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt2 . "<br>" . mysqli_error($this->conn);
}


}





 public function api_putCarnet($id)
    {
$iduser=$_SESSION['userid'];
    $prenom=$_POST['prenom'];
    $nom=$_POST['nom'];
    $datenaissance=null;
    if(isset($_POST['datenaissance'])){
       $datenaissance=$_POST['datenaissance'];
    }

         $mis_a_jour=new DateTime(); 
     $mis_a_jour=$mis_a_jour->format('Y-m-d H:i:s');

$sql = "UPDATE contacts SET prenom='$prenom',nom='$nom', naissance='datenaissance', mis_a_jour='$mis_a_jour' WHERE id='$id' AND iduser='$iduser'";

if (mysqli_query($this->conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($this->conn);
}
    
    }


     public function api_deleteCarnet($id)
    {


$sql = "DELETE FROM contacts WHERE nom='$id' AND iduser='$iduser'";

if ($this->conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    $sql2 = "DELETE FROM adresses WHERE contactid='$id'";
if ($this->conn->query($sql2) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $this->conn->error;
}

} else {
    echo "Error deleting record: " . $this->conn->error;
}
    
    }


public function get_id($texte){
$retour="";
for($i=8;$i<20;$i++){
$retour=$retour.$texte[$i];
if($texte[$i]='""')
  return $retour;

}



}



function getElement($id){
      
$sql = "SELECT*FROM contacts WHERE id='$id'";
$result = mysqli_query($this->conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    return $row;
  }

}







}

    
    ?>