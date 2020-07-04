<?php
function getUserByUserName($userName) {
  $sql = 'SELECT id, firstname, surname, password
            from nyms_fin_db.users
            where username = :username';
  try{
    include "../common/dbConfig.php";
    $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':username' => $userName));
    $result = $sth->fetch();
    $dbh = null;
    return $result;
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
}
?>