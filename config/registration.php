<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

?>
<?php

// Display an error alert if the `error` parameter is set
if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "<script>alert('This email has already been registered. Please try with another email address.');</script>";
} 
elseif (isset($_GET['error']) && $_GET['error'] == 2) {
    echo "<script>alert('Registration failed. Please try again later.');</script>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Sign Up </title>
    <link rel="icon" href="https://localhost/piyushproject/img/sitelogo.png"/>
    <link href="../resource/dist/css/tabler.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-flags.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-payments.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/tabler-vendors.min159a.css?1726507346" rel="stylesheet"/>
    <link href="../resource/dist/css/demo.min159a.css?1726507346" rel="stylesheet"/>
  </head>
  <body  class=" d-flex flex-column">
    <script src="../resource/dist/js/demo-theme.min159a.js?1726507346"></script>
    <div class="page page-center" style="padding-top: 45px;">
      <div class="container container-tight py-4" style="background:#fff !important;">
        
        <form class="card card-md" action="authentication.php" method="POST" autocomplete="off" style="padding-top:35px;">
          <div class="card-body">
            <!--<h2 class="card-title text-center mb-4">Create new account</h2>-->
            <div class="card-title text-center mb-4">
                <a href="../index.php" class="navbar-brand navbar-brand-autodark">
                  <img src="../img/sitelogo.png" alt="Site Logo" style="width:150px;"/>
                </a>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" placeholder="Enter Full Name" name="name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" class="form-control" placeholder="Enter Email Address" name="email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
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
            <!-- Confirm Password Field -->
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Confirm your password" name="password" id="confirmPasswordField" required>
        </div>
            <div class="mb-3">
              <label class="form-label">State</label>
              <input type="text" class="form-control" placeholder="Enter Your State" name="state" required>
            </div>
             <div class="mb-3">
              <label class="form-label">Pincode</label>
              <input type="text" class="form-control" placeholder="Enter Your Pincode" name="pincode" required>
            </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" required/>
                <span class="form-check-label">Agree the <a href="https://localhost/piyushproject/terms-and-conditions.php" tabindex="-1">terms and conditions</a>.</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100" name="submit-user">Create new account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-secondary mt-3">
          Already have account? <a href="login.php" tabindex="-1">Sign in</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    
    <script>
    function validatePasswords() {
        var password = document.getElementById("passwordField").value;
        var confirmPassword = document.getElementById("confirmPasswordField").value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return false; // Prevent form submission
        }
        return true;
    }
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