
 <?php
/**
 *  configuration de la base des donnée
 */
define('DB_USERNAME', 'boua');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'api');
 

/*('SQLServer', 'localhost');
define('SQLLogin', 'boua');
define('SQLPwd', '');
define('SQLDB', 'api');

function dbConnect() {
  global $sqlLogin, $sqlPwd, $sqlDB;
  try {
    $db = new PDO('mysql:host='.SQLServer.';dbname='.SQLDB, SQLLogin, SQLPwd);
    return $db;
  } catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
  }
}*/




/* 
define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);*/

?>