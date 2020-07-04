<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}
$userId = $_SESSION['userid'];
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
          </div>
          <!-- Collapsible content -->
        </div>
        <!-- Additional container -->
      </nav>
      <!--/.Navbar-->

      <style>
        vertical-auto {
          margin-top: auto;
          margin-bottom: auto;
        }
      </style>
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main>
      <!--Main container-->
      <div class="container">

        <!-- add user form -->
        <div class="mt-5 ml-5">

          <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>" />

          <div class="card" style="width: 46rem;">
            <div class="card-header bg-primary">
              <span class="font-weight-bold">Add User</span>
            </div>
            <div class="card-body ">

              <form>
                <div class="form-group">
                  <label for="userName">User Name</label>
                  <input type="text" class="form-control col-sm-6" id="userName" name="userName">
                </div>
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" class="form-control col-sm-6" id="firstName" name="firstName">
                </div>
                <div class="form-group">
                  <label for="surName">Surname</label>
                  <input type="text" class="form-control col-sm-6" id="surName" name="surName">
                </div>
                <div>
                  <label for="password">Password</label>
                    <input type="password" class="form-control col-sm-6" id="password" name="password">
                  </div>
                <button type="button" class="btn btn-primary" onclick="postUser();">Save</button>
              </form>

            </div>
          </div>

        </div>

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
  </body>
</html>
