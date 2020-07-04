<?php
// validate is signed in?
// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);
var_dump(json_decode($json));
// ensure username found
$userName = trim($data->userName);

include "../users/getUserByUserName.php";
$result = getUserByUserName($userName);
// echo print_r( $result);
$id = $result['id'];
if (!$result){
  echo 'Cannot find the user. Please ensure you have the name. or please contact admin.';
  header('Status: 404 NotFound');
  exit;
}

$data = [
  'password' => password_hash($data->password, PASSWORD_DEFAULT),
  'id' => $id
];

include "../common/dbConfig.php";
$sql = "UPDATE `nyms_fin_db`.`users`
          SET password = :password
          WHERE id = :id";

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $sth = $dbh->prepare($sql);
  $sth->execute($data);
  $dbh = null;
  // $stmt->debugDumpParams();
  header('Status: 201 Created');

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>