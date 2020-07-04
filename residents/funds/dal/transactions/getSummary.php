<?php
function getTotalCashAtHand() {
  $sql = "SELECT amountcr, amountdr, (amountcr - amountdr) total_cash_at_hand
          FROM
              (SELECT COALESCE(sum(amount),0) amountcr FROM nyms_fin_db.transactions
                WHERE source_type = 'Cash' and cr_dr = 'Credit') AS cr,
              (SELECT COALESCE(sum(amount),0) amountdr FROM nyms_fin_db.transactions
              WHERE source_type = 'Cash' and cr_dr = 'Debit') AS dr";
    try{
      include "dal/common/dbConfig.php";
      $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
      $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute();
      // $sth->debugDumpParams();
      $result = $sth->fetch();
      $dbh = null;
      return $result;
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
}

function getTotalCashAtBank() {
$sql = "SELECT amountcr, amountdr, (amountcr - amountdr) total_cash_at_bank
        FROM
          (SELECT COALESCE(sum(amount),0) amountcr FROM nyms_fin_db.transactions
            WHERE source_type = 'Bank' AND cr_dr = 'Credit') AS cr,
          (SELECT COALESCE(sum(amount),0) amountdr FROM nyms_fin_db.transactions
            WHERE source_type = 'Bank' and cr_dr = 'Debit') AS dr";
    try{
      include "dal/common/dbConfig.php";
      $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
      $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute();
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