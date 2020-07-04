<?php
function getResidentById($residentId) {
  $sql = 'SELECT id, firstname, surname
            from residents
            where id = :residentid';
  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':residentid' => $residentId));
    $result = $sth->fetch();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>