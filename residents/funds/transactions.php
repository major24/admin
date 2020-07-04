<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ensure resident is passed in and valid
$residentId = htmlspecialchars($_GET["id"]);
$limit = htmlspecialchars($_GET["limit"]);
$userId = $_SESSION['userid'];
$name = '';

require_once('dal/residents/getResidentById.php');
$result = getResidentById($residentId);
// echo print_r( $result);
if (!$result){
  echo 'Cannot find the resident. Please ensure you have the name. or please contact admin.';
  exit;
} else {
  $name = $result['firstname'] . ' ' . $result['surname'];
}


$username = '';
require_once('dal/users/getUserById.php');
$userresult = getUserById($userId);
// echo print_r( $result);
if (!$userresult){
  echo 'Cannot find the user. Please ensure you have the name. or please contact admin.';
  exit;
} else {
  $username = $userresult['firstname'] . ' ' . $userresult['surname'];
}

// get trans and balance info
require_once('dal/transactions/getTransactionsByResidentId.php');
$resulttrans = getTransactionsByResidentId($residentId, $limit);
// echo print_r( $resulttrans);
require_once('dal/transactions/getBalanceByResidentId.php');
$resultbalance = getBalanceByResidentId($residentId);
// echo '>>>' . $resultbalance;
// end of tran and balance info
$styleColorBalance = "#212529";
if ($resultbalance < 0) {
  $styleColorBalance = "#dc3545";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>NYMS Services Ltd</title>
    <!-- MDB icon -->
    <!-- <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon"> -->
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"
    />
    <!-- Google Fonts Roboto -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    />
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/mdb.min.css" />
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="bootstrap/css/style.css" />
    <link rel="stylesheet" href="styles/custom.css" />

    <script src="js/axios-min.js"></script>
    <script src="js/main.js"></script>
  </head>
  <body>
    <!-- Start your project here-->
    <!--Main Navigation-->
    <header>
      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark indigo">
        <!-- Additional container -->
        <div class="container">
          <!-- Navbar brand -->
          <a class="navbar-brand" href="#">
            <!-- <img src="img/logo2.jpeg" alt="logo" /> -->
          </a>

          <!-- Collapse button -->
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#basicExampleNav"
            aria-controls="basicExampleNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Collapsible content -->
          <div class="collapse navbar-collapse" id="basicExampleNav">
            <!-- Links -->
            <ul class="navbar-nav mr-auto">
              <li>
                <img src="img/NymsLogov2.png" class="img-thumbnail" style="width:5em" />
              </li>
              <li class="nav-item">
                <a class="nav-link" href="showAllResidents.php">Residents</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="addResident.php">Add Resident</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
            </ul>
            <!-- Links -->
            <div class="text-white"><?php echo $username ?></div>
          </div>
          <!-- Collapsible content -->
        </div>
        <!-- Additional container -->
      </nav>
      <!--/.Navbar-->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main>
      <div style="background-color:#6876d9">
        <div class="container ml-10 text-white">
          PENNINE Care Centre
        </div>
      </div>

      <!--Main container-->
      <div class="container">

        <div class="mt-5 ml-5">

          <div class="row">
            <div class="col col-sm-6">
              <button type="button" class="btn btn-link" onclick="navigateToCredit(<?php echo $residentId ?>);">Credit</button>
              <button type="button" class="btn btn-link" onclick="navigateToExpense(<?php echo $residentId ?>);">Expense</button>
            </div>
          </div>

          <div class="row">
            <div class="col col-sm-6">
              <h4><strong>Name: <?php echo $residentId, ' - ', $name; ?></strong></h4>
              <input type="hidden" id="residentId" name="residentId" value="<?php echo $residentId ?>" />
              <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>" />
            </div>
            <div class="col col-sm-6">
              <h4>
                Current Balance: &#163;
                  <span style="color:<?php echo $styleColorBalance ?>">
                    <?php echo number_format($resultbalance, 2); ?>
                  </span>
                </h4>
            </div>
          </div>

          <!-- grid rows -->
          <div class="mt-2 ml-1">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Transaction Type</th>
                <th scope="col">Description</th>
                <th scope="col">Credit</th>
                <th scope="col">Debit</th>
                <th scope="col">Print</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resulttrans as $value) {?>
                <tr>
                  <td class="mystyle">
                    <?php echo $value['transaction_date'] ?>
                  </td>
                  <td class="mystyle">
                    <?php echo $value['transaction_type'] ?>
                  </td>
                  <td class="mystyle">
                    <?php echo $value['description'] ?>
                  </td>
                  <td class="mystyle">
                    <?php if (strtolower($value['cr_dr']) == 'credit') {
                        echo number_format($value['amount'], 2);
                    } ?>
                  </td>
                  <td class="mystyle">
                    <?php if (strtolower($value['cr_dr']) == 'debit') {
                        echo number_format($value['amount'], 2);
                    } ?>
                  </td>
                  <td class="mystyle">
                    <?php if (strtolower($value['cr_dr']) == 'credit') { ?>
                      <a target="_blank" href=<?php echo "receiptPdf.php?id=" . $value['id'] . "" ?>>PRT</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div> <!-- mt-5 ml-5 -->


          <!-- grid rows -->

        </div> <!-- mt-5 ml-5-->

      </div>
      <!--Main container-->
    </main>
    <!--Main layout-->

    <!-- End your project here-->

    <!-- jQuery -->
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="bootstrap/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="bootstrap/js/mdb.min.js"></script>
    <!-- Your custom scripts (optional) -->
    <script type="text/javascript"></script>
  </body>
</html>
