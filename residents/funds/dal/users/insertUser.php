<?php
// validate is signed in?
// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);
// validate all fields are there?
// Done at client for the time being..

// var_dump(json_decode($json));
$data = [
  'userName' => $data->userName,
  'firstName' => $data->firstName,
  'surName' => $data->surName,
  'password' => password_hash($data->password, PASSWORD_DEFAULT)
];
// echo $data['password'];
// Insert to table
include "../common/dbConfig.php";
$sql = "INSERT INTO `nyms_fin_db`.`users` (username, firstname, surname, password)
  VALUES (:userName, :firstName, :surName, :password)";

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $stmt= $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;
  // $stmt->debugDumpParams();
  header('Status: 201 Created');

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>