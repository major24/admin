<?php
function getUserById($userId) {
  $sql = 'SELECT id, firstname, surname
            from users
            where id = :userid';
  try{
    include "dal/common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':userid' => $userId));
    $result = $sth->fetch();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>