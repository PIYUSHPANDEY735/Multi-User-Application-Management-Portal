<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Piyush Big Project</title>
    <link rel="icon" href="https://localhost/piyushproject/img/sitelogo.png"/>
    <link href="../resource/dist/css/tabler.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-flags.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-payments.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-vendors.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/demo.min159a.css?1726507346" rel="stylesheet"/>
  </head>
  <body  class=" d-flex flex-column">
    <script src="../resource/dist/js/demo-theme.min159a.js?1726507346"></script>
    <div class="page page-center">
      <div class="container container-tight py-4" style="background:#fff !important;">
        <div class="text-center mb-4">
          <a href="../index.php" class="navbar-brand navbar-brand-autodark">
            <img src="../img/sitelogo.png" alt="Site Logo" style="width:150px;">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <!--<h2 class="h2 text-center mb-4">Login to User Account</h2>-->
           <form class="card card-md" action="check_reset_code.php" method="POST" autocomplete="off">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Verify Your Code</h2>
            <p class="text-secondary mb-4">Enter your Reset Code</p>
            <div class="mb-3">
              <label class="form-label">Reset Code</label>
              <input type="text" class="form-control" placeholder="Enter Code" name="reset_code" required/>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-4 w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="icon icon-2"
                >
                  <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                  <path d="M3 7l9 6l9 -6" />
                </svg>
                Verify Code
              </button>
            </div>
          </div>
        </form>
        <!--<div class="text-center text-secondary mt-3"> <a href="login.php">Back To Login</a></div>-->
          </div>
        <!--  <div class="hr-text">or</div>-->
        <!--  <div class="card-body">-->
        <!--    <div class="row">-->

        <!--        <div class="col">-->
        <!--            <a href="admin_login.php" class="btn w-100">-->
        <!--                Login with Admin-->
        <!--            </a>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <!--<div class="text-center text-secondary mt-3">-->
        <!--  Don't have account yet? <a href="registration.php" tabindex="-1">Sign up</a>-->
        <!--</div>-->
      </div>
    </div>
    <!-- Libs JS -->
    <script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default anchor behavior
        const passwordField = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');

        // Toggle the password field type
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    });
</script>
    <!-- Tabler Core -->
    <script src="../resource/dist/js/tabler.min159a.js?1726507346" defer></script>
    <script src="../resource/dist/js/demo.min159a.js?1726507346" defer></script>
  </body>

</html>