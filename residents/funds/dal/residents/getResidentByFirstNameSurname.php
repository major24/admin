<?php
function getResidentByFirstNameSurname($firstname, $surname) {
  $sql = 'SELECT id, firstname, surname
          FROM nyms_fin_db.residents
          WHERE firstname = :firstname AND surname = :surname';

  try{
    include "../common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':firstname' => trim($firstname), ':surname' => trim($surname)));
    $result = $sth->fetch();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>