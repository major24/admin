<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}
// ensure resident is passed in and valid
$residentId = htmlspecialchars($_GET["id"]);
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

        <!-- income form -->
        <div class="mt-5 ml-5">

          <div class="page-header mb-2">
            <h4><strong>Name: <?php echo $residentId, ' - ', $name; ?></strong></h4>
          </div>
          <input type="hidden" id="residentId" name="residentId" value="<?php echo $residentId ?>" />
          <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>" />

          <div class="card" style="width: 46rem;">
            <div class="card-header bg-primary text-white">
              <span class="font-weight-bold">Credit</span>
            </div>
            <div class="card-body ">

              <form>
                <div class="form-group required">
                  <label for="transactionType">Transaction Type</label>
                  <select class="form-control col-sm-6"
                    id="transactionType"
                    name="transactionType">
                    <optgroup>
                      <option value="">Select</option>
                      <option value="Allowance">Allowance</option>
                      <option value="Resident">Resident</option>
                      <option value="Family">Family</option>
                    </optgroup>
                  </select>
                </div>

                <div class="form-group required">
                  <label for="sourceType">Source Type</label>
                  <select class="form-control col-sm-6"
                    id="sourceType"
                    name="sourceType">
                    <optgroup>
                      <option value="">Select</option>
                      <option value="Cash">Cash</option>
                      <option value="Bank">Bank</option>
                    </optgroup>
                  </select>
                </div>

                <div class="form-group required">
                  <label for="amount">Amount</label>
                  <input type="text" class="form-control col-sm-6" id="amount" name="amount" value="" onkeypress="javascript:return isNumber(event)" />
                </div>
                <div class="form-group">
                  <label for="chqOrReceiptNumber">Cheque / Receipt Number</label>
                  <input type="text" class="form-control col-sm-6" id="chqOrReceiptNumber" name="chqOrReceiptNumber" value="">
                </div>

                <!-- Date Picker Input -->
                <div class="form-group">
                  <label for="transcactionDate">Transation Date</label>
                  <input type="date" class="form-control col-sm-6" id="transactionDate" name="transactionDate" value="" min="2018-01-01" max="2030-12-31" />
                </div>
                <!-- DEnd ate Picker Input -->

                <div class="form-group required">
                  <label for="description">Description</label>
                  <input type="text" id="description" name="description" class="form-control col-sm-6"/>
                </div>
                <button type="button" class="btn btn-primary" onclick="postCredit();">Save</button>
                <!-- <button type="button" class="btn btn">Cancel</button> -->
                <button type="button" class="btn btn-link" onclick="navigateToExpense(<?php echo $residentId ?>);">Expense</button>
                <button type="button" class="btn btn-link" onclick="navigateToTransactions(<?php echo $residentId ?>);">Transactions</button>
              </form>

            </div>
          </div>

        </div> <!-- income form -->

      <!-- toast ctrl Success -->
      <div id="toastControlSuccess" class="toast" data-autohide="false" style="position: absolute; top: 120px; right: 0; width: 300px;">
        <div class="toast-header bg-info text-white">
          <strong class="mr-auto">Success</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          <span id="toastMessageSuccess">Action successfully completed.</span>
        </div>
      </div>
      <!-- toast ctrl -->

      <!-- toast ctrl Error-->
      <div id="toastControlError" class="toast" data-autohide="false" style="position: absolute; top: 120px; right: 0; width: 300px;">
        <div class="toast-header bg-danger text-white">
          <strong class="mr-auto">Error</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          <span id="toastMessageError">Internal system error in processing the call. Contact admin.</span>
        </div>
      </div>
      <!-- toast ctrl -->

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
    <script>
      function setForm() {
        // var today = `${new Date().getFullYear()}-${("0" + (new Date().getMonth() + 1)).slice(-2)}-${new Date().getDate()}`;
        var today = new Date().toISOString().substr(0, 10); //.replace('T', ' ');
        $('#transactionDate').attr('max', today); // '2020-06-25'
      }
      setForm();
    </script>
  </body>
</html>
