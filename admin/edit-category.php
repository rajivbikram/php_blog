<?php
include('../include/db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login
    exit;
}

// Get category data for edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM categories WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $category = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Category not found.";
        $_SESSION['messageType'] = "danger";
        header("Location: index-category.php");
        exit;
    }
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $details = mysqli_real_escape_string($conn, $_POST['category_details']);
    $categoryImage = $_FILES['category_image'];

    // Handle image upload if a new one is provided
    if (!empty($categoryImage['name'])) {
        $imageName = time() . "_" . basename($categoryImage['name']);
        $target_dir = "uploads/category/";
        $target_file = $target_dir . $imageName;

        // Check if image upload is successful
        if (move_uploaded_file($categoryImage['tmp_name'], $target_file)) {
            
            // Remove the old image if it exists
            if (file_exists($target_dir . $category['image'])) {
                unlink($target_dir . $category['image']);
            }

            // Update category details
            $sql = "UPDATE categories SET name = '$name', details = '$details', image = '$imageName' WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "Category updated successfully.";
                $_SESSION['messageType'] = "success";
                header("Location: index-category.php");
                exit;
            } else {
                $message = "Error updating category: " . $conn->error;
                $messageType = "danger";
            }
        } else {
            $message = "Error uploading image.";
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
    <title>Edit Category - Admin</title>
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
                    <h2>Edit Category</h2>
                    <div>
                        <a href="create-category.php" class="btn btn-success">
                            <i class="bi bi-plus"></i> Add New
                        </a>
                        <a href="index-category.php" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> All Category
                        </a>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-body">
                        <form method="post" action="#" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?= $category['id']?>">
                                <div class="form-group">
                                    <label class="form-label">Name 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" 
                                    value="<?= $category['name'] ?>" name="category_name" placeholder="Category Name">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label"> Image 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" name="category_image">
                                    </div>
                                    <div class="mt-3">
                                    <img src="uploads/category/<?= $category['image'] ?>" alt="" width="100px">
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Details 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" name="category_details" id="" rows="5" placeholder="Enter Category details "><?= $category['details'] ?></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="update" class="btn btn-primary">Update Category</button>
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