<?php
function getResidentsAll() {
  $sql = "SELECT id, referencenumber, firstname, surname
            from nyms_fin_db.residents
            WHERE active = 'Y'
            order by firstname, surname";
  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute();
    $result = $sth->fetchAll();
    $dbh = null;
    // $sth->debugDumpParams();
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>