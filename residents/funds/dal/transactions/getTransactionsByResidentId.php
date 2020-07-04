<?php
function getTransactionsByResidentId($residentId, $limit) {
  $sql = 'SELECT id, cr_dr, transaction_type, description, amount, date_format(transaction_date, "%Y-%m-%d") transaction_date, date_format(created, "%Y-%m-%d") created
            FROM nyms_fin_db.transactions
            WHERE resident_id = :resident_id
            ORDER BY id DESC LIMIT ' . $limit;
  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':resident_id' => $residentId));
    // $sth->debugDumpParams();
    $result = $sth->fetchAll();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>