<?php
include('../include/db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login
    exit;
}

// Handle delete action
if (isset($_GET['id'])) {
    $deleteId = intval($_GET['id']);

    // Fetch the image to delete it from the server
    $query = "SELECT image FROM posts WHERE id = $deleteId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = "uploads/post/" . $row['image'];

        // Delete the category record
        $deleteQuery = "DELETE FROM posts WHERE id = $deleteId";
        if ($conn->query($deleteQuery) === TRUE) {
            // Remove the image from the server
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $_SESSION['message'] = "Post deleted successfully.";
            $_SESSION['messageType'] = "success";
            header("Location: index-post.php");
        } else {
            $message = "Error deleting post: " . $conn->error;
            $messageType = "danger";
        }
    }
}