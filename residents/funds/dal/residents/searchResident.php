<?php
session_start();
// Takes raw data from the request
$json = file_get_contents('php://input');
header('Content-Type: application/json');  // <-- header declaration
// Converts it into a PHP object
$data = json_decode($json);

$firstName = trim($data->firstName);
$surname = trim($data->surname);

$firstName = "$firstName%";

// database
include "../common/dbConfig.php";
if ($surname != '') {
  $surname = "$surname%";
  $sql = "SELECT * FROM residents
          WHERE firstname LIKE :firstName
          AND surname LIKE :surname";
} else {
  $sql = "SELECT * FROM residents
  WHERE firstname LIKE :firstName";
}

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $sth = $dbh->prepare($sql);

  if ($surname != '') {
    $sth->execute(array(':firstName' => $firstName, ':surname' => $surname));
  } else {
    $sth->execute(array(':firstName' => $firstName));
  }

  $result = $sth->fetchAll();
  $dbh = null;
  // $sth->debugDumpParams();
  if ($result) {
    header('Status: 200 Ok');
    echo json_encode($result, true);
  } else {
    header('Status: 404 Not Found');
    // echo json_encode($result, true);
  }
} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>