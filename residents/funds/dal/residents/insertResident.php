<?php
// validate is signed in?

// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);
// validate all fields are there? at client side for now..
// validate if fname and surname exists?
require_once('getResidentByFirstNameSurname.php');
$residentresult = getResidentByFirstNameSurname($data->firstName, $data->surname);
echo print_r( $residentresult);
if ($residentresult){
  echo 'Found a user with same name. Please contact admin.';
  header('Status: 400 Bad Request');
  exit;
}

echo 'ready to create user';

// var_dump(json_decode($json));
$data = [
  'referencenumber' => $data->referenceNumber,
  'firstname' => $data->firstName,
  'surname' => $data->surname,
  'middlename' => $data->middleName
];

// Insert to table
$sql = "INSERT INTO `nyms_fin_db`.`residents`
(`referencenumber`,
`firstname`,
`surname`,
`middlename`,
`active`)
VALUES
(:referencenumber,
:firstname,
:surname,
:middlename,
'Y')";

try {
  include "../common/dbConfig.php";
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $stmt= $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;

  header('Status: 201 Created');

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>