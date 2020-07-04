<?php
session_start();
// Takes raw data from the request
$json = file_get_contents('php://input');
header('Content-Type: application/json');  // <-- header declaration
// Converts it into a PHP object
$data = json_decode($json);

$userName = trim($data->userName);
$password = trim($data->password); // trim('1234');

// database
include "../common/dbConfig.php";
$sql = "SELECT id, password FROM users
          WHERE username = :userName
          AND active ='Y'";

try {
  $dbh = new PDO('mysql:host=localhost;dbname=' . $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $sth->execute(array(':userName' => $userName));
  $result = $sth->fetch();
  $dbh = null;

  if ($result && password_verify($password, $result['password'])) {
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['userid'] = $result['id'];
    header('Status: 200 Ok');
    // header("Location: http://www.example.com/"); /* Redirect browser */
    exit;
  } else {
    header("HTTP/1.0 404 Not Found");
    exit;
  }

} catch (mysqli_sql_exception $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>