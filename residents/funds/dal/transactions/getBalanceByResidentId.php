<?php
function getBalanceByResidentId($residentId) {

  $sql1 = 'SELECT  SUM(amount) Credit
    FROM nyms_fin_db.transactions
    WHERE resident_id = :resident_id
    and cr_dr = "Credit"';
  $sql2 = 'SELECT  SUM(amount) Debit
    FROM nyms_fin_db.transactions
    WHERE resident_id = :resident_id
    AND cr_dr = "Debit"';

  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth1 = $dbh->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth2 = $dbh->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth1->execute(array(':resident_id' => $residentId));
    $sth2->execute(array(':resident_id' => $residentId));
    $result1 = $sth1->fetch();
    $result2 = $sth2->fetch();
    $dbh = null;
    // print_r($result1['credit'] - $result2['debit']);
    return $result1['Credit'] - $result2['Debit'];
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>