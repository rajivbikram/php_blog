<?php
include('include/db.php');

// success or danger message
$message = "";
$messageType = ""; 

// Function to register a user
if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        $message = "Email is already registered.";
        $messageType = "danger";
    } else {
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            session_start();
            $_SESSION['message'] = "Registration successful. Please login.";
            $_SESSION['messageType'] = "success";
            header("Location: login.php");
            exit;
        } else {
            $message = "Error: " . $conn->error;
            $messageType = "danger";
        }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
                        <h2>Create Account</h2>
                        <p>Enter your details.</p>
                        <form method="post" action="#">
                            <div class="form-group">
                                <label class="form-label" for="fullname">Full Name 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" name="fullname" placeholder="Enter your fullname">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" for="email">Email 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" for="password">Password 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100 mt-4">Register</button>
                            <div class="mt-4 text-center">
                                <p>
                                    Already have an Account? <a href="login.php" class="fw-semibold">Login</a>
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