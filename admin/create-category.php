<?php
include('../include/db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login
    exit;
}

if (isset($_POST['save'])) {
    $categoryName = mysqli_real_escape_string($conn, $_POST['category_name']);
    $categoryDetails = mysqli_real_escape_string($conn, $_POST['category_details']);
    $categoryImage = $_FILES['category_image'];

    // Validation
    if (empty($categoryName)) {
        $message = "Category name is required.";
        $messageType = "danger";
    } elseif (empty($categoryDetails)) {
        $message = "Category details are required.";
        $messageType = "danger";
    } elseif (empty($categoryImage['name'])) {
        $message = "Category image is required.";
        $messageType = "danger";
    } else {
        // Image upload handling
        $imageName = time() . "_" . basename($categoryImage['name']);
        $target_dir = "uploads/category/";
        $target_file = $target_dir . $imageName;

        if (move_uploaded_file($categoryImage['tmp_name'], $target_file)) {
            // Insert category into the database
            $sql = "INSERT INTO categories (name, details, image) VALUES ('$categoryName', '$categoryDetails', '$imageName')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "Category added successfully.";
                $_SESSION['messageType'] = "success";
                header("Location: index-category.php");
            } else {
                $message = "Error: " . $conn->error;
                $messageType = "danger";
            }
        } else {
            $message = "Failed to upload the image.";
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
    <title>Create Category - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3">
                <?php include('layouts/sidebar.php'); ?>
            </div>
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Create Category</h2>
                    <a href="index-category.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> All Category
                    </a>
                </div>
                <?php if (!empty($message)): ?>
                    <div class="mt-3 alert alert-<?= $messageType ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-label">Name 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="category_name" placeholder="Category Name">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label">Image 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" name="category_image">
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Details 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" name="category_details" id="" rows="5" placeholder="Enter Category details "></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="save" class="btn btn-primary">Save Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>