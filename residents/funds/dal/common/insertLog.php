<?php
// validate is signed in?
// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);

// var_dump(json_decode($json));
$data = [
  'userid' => $data->userId,
  'logtype' => $data->logType,
  'description' => $data->description
];

// Insert to table
include "../common/dbConfig.php";
$sql = "INSERT INTO `nyms_fin_db`.`logs` (userid, logtype, description)
  VALUES (:userid, :logtype, :description)";

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $stmt= $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;
  // $stmt->debugDumpParams();
  // header('Status: 201 Created');
  die();

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>