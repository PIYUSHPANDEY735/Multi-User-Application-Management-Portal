<?php
include("connection.php");

$message = '';

// Handle GET request to show form
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is still valid
    $stmt = $conn->prepare("SELECT * FROM user WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {?>
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
            <img src="https://localhost/piyushproject/img/sitelogo.png" alt="Site Logo" style="width:150px;">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
           <form class="card card-md" action="" method="POST" autocomplete="off">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Update Your Password</h2>
            <div class="mb-3">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
              <label class="form-label">New Password</label>
              <div class="input-group input-group-flat">
                 <input type="password" name="new_password" class="form-control" placeholder="Enter Password" id="passwordField"  required/>
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
             <?php if (!empty($message)) {
    echo "<h2 class='card-title text-center mb-4 mt-4'>$message</h2>";
    // Add JavaScript to redirect the user to the login page after 3 seconds
    echo "<script>
            setTimeout(function() {
                window.location.href = 'https://localhost/piyushproject/config/login.php';
            }, 3000); // 3000 milliseconds = 3 seconds
          </script>";
}?>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-4 w-100">
                Reset Password
              </button>
            </div>
          </div>
        </form>
          </div>
          </form>
          </div>
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
   <?php } else {
        // Expired or invalid — clear token just in case
        $stmt = $conn->prepare("UPDATE user SET reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $message = "The reset link is invalid or has expired.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'], $_POST['token'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    // Re-verify the token
    $stmt = $conn->prepare("SELECT * FROM user WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password and clear token
        $update = $conn->prepare("UPDATE user SET Password = ?, reset_token = NULL, token_expiry = NULL WHERE userid = ?");
        $update->bind_param("si", $hashed_password, $user['userid']);
        $update->execute();
        echo "<script>
        alert('Password has been Successfully Updated');
        window.location.href='login.php';
        </script>";
        $message = "Your Password has been successfully updated.";
    } else {
        // Token is expired — clear token to prevent reuse
        $stmt = $conn->prepare("UPDATE user SET reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $message = "Invalid or expired token.";
    }
}

//echo $message;  Display the message to the user (success or error)
?>
