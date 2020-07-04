<?php
// session_start();
// vaidate is signed in

// Takes raw data from the request
$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json);
// valiate all fields are there
// Done at client for the time being..

var_dump(json_decode($json));
$data = [
  'resident_id' => $data->residentId,
  'user_id' => $data->userId,
  'cr_dr' => $data->crDr,
  'transaction_type' => $data->transactionType,
  'source_type' => $data->sourceType,
  'chq_or_receipt_number' => $data->chqOrReceiptNumber,
  'amount' => $data->amount,
  'description' => $data->description,
  'transaction_date' => ($data->transactionDate == "") ? date("Y-m-d") : $data->transactionDate
];

// Insert to table
$sql = "INSERT INTO `nyms_fin_db`.`transactions`
(`resident_id`,
`user_id`,
`cr_dr`,
`transaction_type`,
`source_type`,
`chq_or_receipt_number`,
`amount`,
`description`,
`transaction_date`)
VALUES
(:resident_id,
:user_id,
:cr_dr,
:transaction_type,
:source_type,
:chq_or_receipt_number,
:amount,
:description,
:transaction_date)";

try {
  include "../common/dbConfig.php";
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $stmt= $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;
  $stmt->debugDumpParams();
  header('Status: 201 Created');

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
exit;
?>