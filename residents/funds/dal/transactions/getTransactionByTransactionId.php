<?php
function getTransactionByTransactionId($transactionId) {

$sql = 'SELECT t.id, t.resident_id, t.transaction_type, t.amount, t.description,
            date_format(t.transaction_date, "%Y-%m-%d") transaction_date,
            r.firstname, r.surname
          FROM nyms_fin_db.transactions t
          INNER JOIN nyms_fin_db.residents r ON t.resident_id = r.id
          WHERE t.id = :transaction_id';
  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':transaction_id' => $transactionId));
    // $sth->debugDumpParams();
    $result = $sth->fetch();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>