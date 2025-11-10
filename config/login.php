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
    <title>Log in</title>
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
            <img src="https://localhost/piyushproject/img/sitelogo.png" alt="Site Logo" style="width:150px;">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body" style="padding-top:15px;padding-bottom:15px;">
            <h2 class="h2 text-center">Login to User Account</h2>
            <form action="login_authentication.php" method="POST" autocomplete="off">
              <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" placeholder="your@email.com" autocomplete="off" name="email" required>
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                </label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" placeholder="Your password" autocomplete="off" name="password" id="passwordField" required>
            <span class="input-group-text">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" id="togglePassword">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" id="eyeIcon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>
                </a>
            </span>
                </div>
              </div>
              <div class="mb-2" style="text-align:right;">
                  <label><a href="forget-password.php">Forgot Password ?</a></label>
              </div>
              
              <div class="form-footer" style="margin-top:15px;">
                <button type="submit" class="btn btn-primary w-100" name="login-user">Log in</button>
              </div>
            </form>
          </div>
          <div class="hr-text">or</div>
          <div class="card-body" style="padding-top:15px;">
            <div class="row">

                <div class="col">
                    <a href="admin_login.php" class="btn w-100">
                        Login with Admin
                    </a>
                </div>
            </div>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Don't have account yet? <a href="registration.php" tabindex="-1">Sign up</a>
        </div>
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