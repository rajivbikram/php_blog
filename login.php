<?php
include('include/db.php');

// Display alert message from session, if exists
session_start();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['messageType'];
    unset($_SESSION['message'], $_SESSION['messageType']);
}

// Function to log in a user
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($email)) {
        $message = "Email cannot be empty.";
        $messageType = "danger";
    } elseif (empty($password)) {
        $message = "Password cannot be empty.";
        $messageType = "danger";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $messageType = "success";
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: admin/dashboard.php");
            } else {
                $message = "Invalid password.";
                $messageType = "danger";
            }
        } else {
            $message = "No account found with that email.";
            $messageType = "danger";
        }
    }
}

$conn->close();
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 mx-auto">
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?= $messageType ?>" role="alert">
                    <?= $message ?>
                </div>
            <?php endif; ?>
                <div class="card">
                    <div class="card-body p-4">
                        <h2>Login</h2>
                        <p>Enter your email and password for login.</p>
                        <form method="post" action="#">
                            <div class="form-group">
                                <label class="form-label" for="email">Email 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                            </div>
                            <div class="form-group mt-4">
                                <label class="form-label" for="password">Password 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-lg w-100 mt-4">Login</button>
                            <div class="mt-4 text-center">
                                <p>
                                    Don't have an Account? <a href="register.php" class="fw-semibold">Register</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>