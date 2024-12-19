<?php
include('../include/db.php');

session_start();

// success or danger message
$message = "";
$messageType = ""; 

if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php"); // Redirect to login
  exit;
}

// Get Categories from category table
$categories = [];
$sql = "SELECT * FROM categories ORDER BY name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Handle post creation
if (isset($_POST['save'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $category_id = intval($_POST['category_id']);
    $image = "";

    // Validate inputs
    if (empty($title) || empty($details) || empty($status) || empty($category_id)) {
        $message = "All fields are required.";
        $messageType = "danger";
    } else {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/post/";
            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $imageName;

            // Check if image upload is successful
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $image = $imageName;
            } else {
                $message = "Error uploading image.";
                $messageType = "danger";
            }
        }

        if (empty($message)) {
            // Insert post into the database
            $sql = "INSERT INTO posts (title, details, image, status, category_id) VALUES ('$title', '$details', '$image', '$status', $category_id)";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = "Post created successfully.";
                $_SESSION['messageType'] = "success";
                header("Location: index-post.php");
                exit;
            } else {
                $message = "Error creating post: " . $conn->error;
                $messageType = "danger";
            }
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
    <title>Create Post - Admin</title>
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
                    <h2>Create Post</h2>
                    <a href="index-post.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> All Posts
                    </a>
                </div>
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $messageType ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="form-label">Post Title 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Post Title">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label">Post Image 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <div class="form-group col-md-6 mt-3">
                                        <label class="form-label">Category 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="category_id" name="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Post Details 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" name="details" id="" rows="10" placeholder="Enter Post details "></textarea>
                                </div>
                                <div class="mt-3">
                                <label for="status" class="form-label">Post Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="0">Draft</option>
                                        <option value="1">Published</option>
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="save" class="btn btn-primary">Save Post</button>
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