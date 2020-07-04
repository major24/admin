<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  // header('Location: login.php');
  exit;
}
// // ensure resident is passed in and valid
$transactionId = htmlspecialchars($_GET["id"]);
$userId = $_SESSION['userid'];
$name = '';

require_once('dal/transactions/getTransactionByTransactionId.php');
$result = getTransactionByTransactionId($transactionId);
// echo print_r( $result);
if (!$result){
  echo 'Cannot find the record. Please ensure you have the name. or please contact admin.';
  exit;
} else {
  $name = $result['firstname'] . ' ' . $result['surname'];
}


$username = '';
require_once('dal/users/getUserById.php');
$userresult = getUserById($userId);
// echo print_r( $result);
if (!$userresult){
  echo 'Cannot find the user. Please ensure you have the name. or please contact admin.';
  exit;
} else {
  $username = $userresult['firstname'] . ' ' . $userresult['surname'];
}

// C:\inetpub\wwwroot\admin\residents/funds
$path = $_SERVER['DOCUMENT_ROOT'];  // C:\inetpub\wwwroot
//echo $path;
$pdfpath = $path . '/admin/residents/funds/fpdf182/';
//echo $pdfpath;
require($pdfpath . 'fpdf.php');

// dynamic variables
$receiptid = $result['id'];
$transactiondate = $result['transaction_date'];
$amount = $result['amount'];
$residentname = $name;
$transactionType = $result['transaction_type'];
// end of dyanmic variables


// Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
// Rect(float x, float y, float w, float h [, string style])
// Line(float x1, float y1, float x2, float y2)
$pdf = new FPDF();
$pdf->AddPage();
// border for the entire receipt
$pdf->Rect(10, 10, 180, 180);
// header
$pdf->SetFont('Arial','',30);
$pdf->Text(20, 24,'Receipt');

$pdf->SetFont('Arial','',12);
// receipt number and line beside it
$pdf->Text(150, 24, 'No.');
// $pdf->Line(160, 24, 180, 24);
$pdf->Text(160, 24, $receiptid);                 // dynamic value

// border line under receipt and receipt number
$pdf->Line(20, 26, 180, 26);

// amount box and text
define('GBP',chr(163));
$pdf->Text(120, 40, 'Amount');
$pdf->Rect(140, 32, 40, 10);
$pdf->Text(150, 40, GBP. ' ' . $amount);          // dynamic value

// date received from with line
$pdf->Text(20, 50, 'Date');
$pdf->Text(40, 49, $transactiondate);             // dynamic value

$pdf->Text(20, 60, 'From');
$pdf->Line(32, 50, 70, 50);  // line for date
$pdf->Line(32, 60, 170, 60); // line for 'From field'
//$pdf->Text()

// extra line for amount in sentence
$pdf->Text(156, 68, 'Pounds');
$pdf->Line(32, 70, 170, 70);

// reason
$pdf->Text(20, 84, 'For Resident');
$pdf->Line(50, 84, 170, 84);
$pdf->Text(55, 83, $residentname);                   // dynamic value

$pdf->Text(20, 94, 'Reason Code');
$pdf->Line(50, 94, 170, 94);
$pdf->Text(55, 93, $transactionType);                    // dynamic value

// received by
$pdf->Text(20, 120, 'Received By');
$pdf->Line(50, 120, 100, 120);

// penninecare info
$pdf->SetFont('Arial','',8);
$pdf->Text(20, 156, '* Printed at Pennine Care Centre *');
$filename = 'Receipt-' . $receiptid . '.pdf';
$pdf->Output('I', $filename);
?>