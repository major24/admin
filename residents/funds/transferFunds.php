<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}

$userId = $_SESSION['userid'];
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

        <!-- expense form -->
        <div class="mt-5 ml-5">

          <div class="page-header mb-2">
            <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>" />
          </div>


          <div class="card" style="width: 46rem;">
            <div class="card-header bg-warning text-white">
              <span class="font-weight-bold">Transfer Funds</span>
            </div>
            <div class="card-body ">
              <div class="mb-2">Move money from Bank to Cash at hand or from Cash at hand to Bank</div>
              <form>
                <div class="form-group required">
                  <label for="sourceType">Source Type</label>
                  <select class="form-control col-sm-6"
                    id="sourceType"
                    name="sourceType">
                    <optgroup>
                      <option value="">Select</option>
                      <option value="CashToBank">From Cash to Bank</option>
                      <option value="BankToCash">From Bank to Cash</option>
                    </optgroup>
                  </select>
                </div>

                <div class="form-group required">
                  <label for="amount">Amount</label>
                  <input type="text" class="form-control col-sm-6" id="amount" name="amount" onkeypress="javascript:return isNumber(event)" />
                </div>

                <div class="form-group required">
                  <label for="amount">Description</label>
                  <input type="text" id="description" class="form-control col-sm-6" />
                </div>
                <button type="button" class="btn btn-primary" onclick="postTransferFunds();">Save</button>
              </form>

          </div>
        </div>

      </div>

        <!-- toast ctrl -->
        <div id="toastControl" class="toast" data-autohide="false" style="position: absolute; top: 120px; right: 0; width: 300px;">
          <div class="toast-header bg-info text-white">
            <strong class="mr-auto">Message</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            <span id="toastMessage">Internal system error in processing the call. Contact admin.</span>
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
  </body>
</html>
