<?php
include('../include/db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php"); // Redirect to login
  exit;
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  $messageType = $_SESSION['messageType'];
  unset($_SESSION['message'], $_SESSION['messageType']);
}


$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = $conn->query($sql);
$serialNumber = 1;

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3">
              <?php include('layouts/sidebar.php'); ?>
            </div>
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Categories</h2>
                    <a href="create-category.php" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Add New
                    </a>
                </div>
                <?php if (!empty($message)): ?>
                    <div class="mt-4 alert alert-<?= $messageType ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">S.N</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                          <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                              <th scope="row"><?= $serialNumber++ ?></th>
                              <td><?= $row['name'] ?></td>
                              <td>
                                  <img src="uploads/category/<?= $row['image'] ?>" alt="" width="50px">
                              </td>
                              <td>
                                  <a href="edit-category.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                                      <i class="bi bi-pencil"></i>
                                  </a>
                                  <a href="delete-category.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                                      <i class="bi bi-trash"></i>
                                  </a>
                              </td>
                            </tr>
                          <?php endwhile; ?>
                          <?php else: ?>
                              <tr>
                                  <td colspan="5" class="text-center">No categories found.</td>
                              </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                  </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>