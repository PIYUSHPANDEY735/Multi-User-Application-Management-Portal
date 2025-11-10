<?php

if (isset($_GET['error']) && $_GET['error'] == 1) {
  echo "<script>alert('Invalid Admin credentials. Please try again.');</script>";
}
?>
<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Log into Admin</title>
  <link rel="icon" href="../assets/img/favicon.webp" />
  <link rel="shortcut icon" href="../img/newlogooo.png" type="image/x-icon" />
  <link href="../resource/dist/css/tabler.min159a.css?1726507346" rel="stylesheet" />
  <link href="../resource/dist/css/tabler-flags.min159a.css?1726507346" rel="stylesheet" />
  <link href="../resource/dist/css/tabler-payments.min159a.css?1726507346" rel="stylesheet" />
  <link href="../resource/dist/css/tabler-vendors.min159a.css?1726507346" rel="stylesheet" />
  <link href="../resource/dist/css/demo.min159a.css?1726507346" rel="stylesheet" />

</head>

<body class=" d-flex flex-column bg-white">
  <script src="../resource/dist/js/demo-theme.min159a.js?1726507346"></script>
  <div class="row g-0 flex-fill">
    <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
      <div class="container container-tight my-5 px-lg-5">
        <div class="text-center mb-4">
          <a href="../index.php" class="navbar-brand navbar-brand-autodark"><img src="https://localhost/piyushproject/img/sitelogo.png" alt="Site Logo" style="width:150px;"></a>
        </div>
        <h2 class="h3 text-center mb-3">
          Login to Admin Account
        </h2>
        <form action="admin_authentication.php" method="post" autocomplete="off" novalidate>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" placeholder="email123@gmail.com" autocomplete="off" name="email" required>
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
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Log in</button>
          </div>
        </form>
      </div>

      <div class="card-body">
        <div class="row">

          <div class="col">
            <a href="login.php" class="btn w-100">
              Login with User
            </a>
          </div>
        </div>
      </div>
      <div class="hr-text">or</div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <a href="subadmin.php" class="btn w-100">
              Login with Sub Admin
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
      <!-- Photo -->
      <div class="bg-cover h-100 min-vh-100" style="background-image: url(../resource/static/photos/finances-us-dollars-and-bitcoins-currency-money-2.jpg)"></div>
    </div>
  </div>
  <!-- Libs JS -->

  <!-- JavaScript for toggling password visibility -->
  <script>
    document.getElementById('togglePassword').addEventListener('click', function(e) {
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