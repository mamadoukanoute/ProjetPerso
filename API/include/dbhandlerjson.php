<?php
 
/**
 * Classe pour gérer toutes les opérations de db
 * Cette classe aura les méthodes CRUD pour les tables de base de données
 *
 
 */
class Dbhandler {
    private $conn;
    public $taille;
    function __construct() {
        require_once dirname(__FILE__) . '/dbconnect.php';
        //Ouverture connexion db
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    
    

  

    function api_getcarnet()
    {
      
$sql = "SELECT*FROM contacts ";
$result = mysqli_query($this->conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
          
           'id' => $row['id'],
             'prenom' => $row['prenom'],
            'nom' => $row['nom'],
             'datenaissance' => $row['naissance'],
            'cree' => $row['cree'],
            'mis_a_jour' => $row['mis_a_jour'],
            'adresse'=>$this->api_getcarnetdetail2($row['nom'])
      
        );
        //echo $tab['prenom'];
      }
        return json_encode($data);
  // echo json_encode($data);
    }
}

    function api_getcarnetdetail($id)
    {
      $iduser=$_SESSION['userid'];

$sql = "SELECT*FROM contacts WHERE nom='$id'";
$result = mysqli_query($this->conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
          'id' => $row['id'],
             'prenom' => $row['prenom'],
            'nom' => $row['nom'],
             'datenaissance' => $row['naissance'],
            'cree' => $row['cree'],
            'mis_a_jour' => $row['mis_a_jour'],
         
      
        );
        //echo $tab['prenom'];
      }
       return json_encode($data);
  // echo json_encode($data);
    }
}

    function api_getcarnetdetail2($id)
    {
      
$sql = "SELECT*FROM adresses WHERE contactid='$id'";
$result = mysqli_query($this->conn, $sql);

$data=array();
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
          'id' => $row['id'],
           'rue' => $row['rue'],
      'codepostal' => $row['code_postal'],
            'ville' => $row['ville'],
            'cree' => $row['cree'],
            'mis_a_jour' => $row['mis_a_jour'],
           // 'adresse'=>$this->api_getcarnetdetail2($row['id'])

      
        );
        //echo $tab['prenom'];
      }
     //echo json_encode($data);
      return json_encode($data);
    }
    
}




  public function api_postCarnet()
    {

      $info=$_POST['info'];
      $adresse=$_POST['adresse'];
          //{"civilite":1,"prenom":2,"nom":3,"adresse":3}
      //{"civilite":1,"prenom":2,"nom":3,"adresse":{ "rue":1,"code":1234,"ville":test}}

      // $test=json_decode($info);
$test=json_decode($info, true);

/*echo "civilite ".$test['civilite']."<br/>";
echo "prenom ".$test['prenom']."<br/>";
echo "nom ".$test['nom']."<br/>";
echo "Naissance ".$test['datenaissance']."<br/>";

//echo "adresse ".$test['adresse']."<br/>";
//echo $adresse;
$test1=$test['adresse'];

echo "rue ".$test1['rue']."<br/>";
if(isset($test1['code']))
echo "code ".$test1['code']."<br/>";
echo "ville ".$test1['ville']."<br/>";
}*/
       //echo $test;
      //var_dump(json_encode($info));
       /*echo "dd";
       echo $test['name'];*/

$civilite=$test['civilite'];
    $prenom=$test['prenom'];
    $nom=$test['nom'];
    $test1=$test['adresse'];

    $code_postal=$test1['code'];
    $ville=$test1['ville'];
    $rue='';
    $datenaissance=null;

   if(isset($test['datenaissance'])){
       $datenaissance=$test['datenaissance'];
    }
    if(isset($test1['rue'])){
       $rue=$test1['rue'];
    }
    $cree=new DateTime();
    $cree=$cree->format('Y-m-d H:i:s');
     $mis_a_jour=new DateTime(); 
     $mis_a_jour=$mis_a_jour->format('Y-m-d H:i:s'); 

$iduser=$_SESSION['userid'];
 $stmt1 = "INSERT INTO contacts(iduser,civilite,prenom, nom,naissance,cree,mis_a_jour ) VALUES ('$iduser','$civilite','$prenom','$nom','$datenaissance','$cree','$mis_a_jour')";



if (mysqli_query($this->conn, $stmt1)) {
    echo "New record created successfully";



      $stmt2 = "INSERT INTO adresses (contactid,rue,code_postal, ville,cree,mis_a_jour ) VALUES ('$nom','$rue','$code_postal','$ville','$cree','$mis_a_jour')";




if (mysqli_query($this->conn, $stmt2)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt2 . "<br>" . mysqli_error($this->conn);
}

} else {
    echo "Error: " . $stmt1 . "<br>" . mysqli_error($this->conn);
}
   




}

 public function api_postCarnetjson2($civilite,$prenom,$nom,$datenaissance,$cree,$mis_a_jour)
    {
$iduser=$_SESSION['userid'];


 $stmt1 = "INSERT INTO contacts(iduser,civilite,prenom, nom,naissance,cree,mis_a_jour ) VALUES ('$iduser','$civilite','$prenom','$nom','$datenaissance','$cree','$mis_a_jour')";


if (mysqli_query($this->conn, $stmt1)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt1 . "<br>" . mysqli_error($this->conn);
}
}

public function api_postCarnetjson($contactid,$rue,$code_postal,$ville,$cree,$mis_a_jour)
    {

 
$stmt2 = "INSERT INTO adresses (contactid, rue,code_postal, ville,cree,mis_a_jour ) VALUES ('$contactid','$rue','$code_postal','$ville','$cree','$mis_a_jour')";
   

if (mysqli_query($this->conn, $stmt2)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt2 . "<br>" . mysqli_error($this->conn);
}


}


  public function utilisateur($username,$password,$email)
    {


    $username=$_POST['username'];
    $password=$_POST['password'];
      $email=$_POST['email'];
 

$stmt2 = "INSERT INTO user (username,motdepasse,email) VALUES ('$username','$password','$email')";


if (mysqli_query($this->conn, $stmt2)) {
    echo "Enregistrement effectué";
   header("location: http://localhost/API");

} else {
    echo "Error: " . $stmt2 . "<br>" . mysqli_error($this->conn);
}


}



  



  public function api_postadresse($contact)
    {

  $adresse=$_POST['adresse'];
$test1=json_decode($adresse, true);

   
    $ville=$test1['ville'];
    $code=$test1['code'];
  $rue="";

     if(isset($test1['rue'])){
       $rue=$test1['rue'];
    }


    $cree=new DateTime();
    $cree=$cree->format('Y-m-d H:i:s');
     $mis_a_jour=new DateTime(); 
     $mis_a_jour=$mis_a_jour->format('Y-m-d H:i:s'); 

$stmt2 = "INSERT INTO adresses (contactid, rue,code_postal, ville,cree,mis_a_jour ) VALUES ('$contact','$rue','$code','$ville','$cree','$mis_a_jour') ";


if (mysqli_query($this->conn, $stmt2)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt2 . "<br>" . mysqli_error($this->conn);
}


}

 public function api_putCarnet($id,$taille)
    {

        $info=$_POST['info'];

$test=json_decode($info, true);

    $prenom=$test['prenom'];

    $datenaissance="";

     $iduser=$_SESSION['userid'];


    if(isset($test['datenaissance'])){
       $datenaissance=$test['datenaissance'];
    }
echo $id."<br/>";
echo $iduser."<br/>";
echo $prenom."<br/>";
echo $datenaissance."<br/>";
         $mis_a_jour=new DateTime(); 
     $mis_a_jour=$mis_a_jour->format('Y-m-d H:i:s');
     //echo "0 ";

$sql = "UPDATE contacts SET prenom='$prenom', naissance='$datenaissance', mis_a_jour='$mis_a_jour' WHERE nom='$id' AND iduser='$iduser'";

if (mysqli_query($this->conn, $sql)) {
echo "Record updated successfully";

for($i=0;$i<$taille;$i++){
  $adressenom='adresse'.$i;
  echo $adressenom;
  $adresse=$_POST[$adressenom];
$test1=json_decode($adresse, true);
$hiddennom='hidden'.$i;
$id2=$_POST[$hiddennom];

   
    $ville=$test1['ville'];
    $code=$test1['code'];
  $rue="";

     if(isset($test1['rue'])){
       $rue=$test1['rue'];
    }

    $sql = "UPDATE adresses SET rue='$rue',code_postal='$code', ville='$ville', mis_a_jour='$mis_a_jour' WHERE contactid='$id' AND id='$id2'";

if (mysqli_query($this->conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($this->conn);
}

  }


} else {
    echo "Error updating record: " . mysqli_error($this->conn);
}






    
    }


     public function api_deleteCarnet($id)
    {

$iduser=$_SESSION['userid'];
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