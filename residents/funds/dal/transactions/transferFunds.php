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
// validate if bank user exists?
require_once('../residents/getResidentByFirstNameSurname.php');
$resultBankUser = getResidentByFirstNameSurname('bankuser', 'bankuser');
if (!$resultBankUser){
  echo 'Could not find BANK place holder user. Please contact admin.';
  header('Status: 500 Internal Error');
  exit;
}
echo print_r( $resultBankUser);

// Create two data structures.
// One to CR / DR bank, other to CR / DR offseting transactions
// e.g CashToBank -> Bank = CR   Cash = DR
$sourceTypeCredit = '';
$sourceTypeDebit = '';

if ($data->sourceType === 'CashToBank') {
  $sourceTypeCredit = 'Bank';
  $sourceTypeDebit = 'Cash';
} else if ($data->sourceType === 'BankToCash') {
  $sourceTypeCredit = 'Cash';
  $sourceTypeDebit = 'Bank';
}

$dataCrdit= [
  'resident_id' => $resultBankUser['id'],
  'user_id' => $data->userId,
  'cr_dr' => 'Credit',
  'transaction_type' => $data->sourceType,
  'source_type' => $sourceTypeCredit,
  'chq_or_receipt_number' => '',
  'amount' => $data->amount,
  'description' => $data->description,
  'transaction_date' => date("Y-m-d")
];

$dataDebit= [
  'resident_id' => $resultBankUser['id'],
  'user_id' => $data->userId,
  'cr_dr' => 'Debit',
  'transaction_type' => $data->sourceType,
  'source_type' => $sourceTypeDebit,
  'chq_or_receipt_number' => '',
  'amount' => $data->amount,
  'description' => $data->description,
  'transaction_date' => date("Y-m-d")
];

echo print_r($dataCrdit);
echo '';
echo print_r($dataDebit);


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
  $stmt->execute($dataCrdit);
  $stmt->execute($dataDebit);
  $dbh = null;
  $stmt->debugDumpParams();
  header('Status: 201 Created');

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
exit;
?>