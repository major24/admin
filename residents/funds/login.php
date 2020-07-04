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
            </ul>
            <!-- Links -->
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

      <!-- loging form -->
      <div class="mt-5 ml-5">

        <div class="row">
          <div class="col-sm offset-2">

            <div class="card" style="width: 46rem;">
              <div class="card-header bg-warning">
                <span class="font-weight-bold">Login</span>
              </div>
              <div class="card-body ">

                <form>
                  <div class="form-group">
                    <label for="userName">User name</label>
                    <input type="text" class="form-control col-sm-6" id="userName" name="userName">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control col-sm-6" id="password" name="password">
                  </div>
                  <button type="button" class="btn btn-primary" onclick="validateLogin();">Submit</button>
                </form>

              </div>
            </div>

          </div>
        </div>

      </div>
      <!-- loging form -->


      <!-- pwd change toggle control -->
      <div class="mt-5 ml-5">
        <div class="row">
          <div class="col-sm offset-2">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapsePasswordChange" aria-expanded="false">
              <label>Change Password</label>
            </button>
          </div>
        </div>
      </div>
      <!-- pwd change toggle control -->


      <!-- change password -->
      <div class="collapse" id="collapsePasswordChange">
        <div class="mt-5 ml-5">

          <div class="row">
            <div class="col-sm offset-2">

              <div class="card" style="width: 46rem;">
                <div class="card-header bg-warning">
                  <span class="font-weight-bold">Change Password</span>
                </div>
                <div class="card-body ">

                  <form>
                    <div class="form-group">
                      <label for="userName">User name</label>
                      <input type="test" class="form-control col-sm-6" id="resetUserName" name="resetUserName">
                    </div>
                    <div class="form-group">
                      <label for="password">Currnt Password</label>
                      <input type="password" class="form-control col-sm-6" id="currentPassword" name="currentPassword">
                    </div>
                    <div class="form-group">
                      <label for="password">New Password</label>
                      <input type="password" class="form-control col-sm-6" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group">
                      <label for="password">Confirm Password</label>
                      <input type="password" class="form-control col-sm-6" id="confirmPassword" name="confirmPassword">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="changePassword();">Submit</button>
                  </form>

                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      <!-- change password -->


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
