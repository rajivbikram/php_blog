<?php
    //  basename() function returns the filename from a path.
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="list-group">
    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?> list-group-item list-group-item-actio" aria-current="true">
        <i class="bi bi-speedometer2 me-1"></i> Dashboard
    </a>
    <a href="index-post.php" class="<?= $currentPage == 'index-post.php' ? 'active' : '' ?> list-group-item list-group-item-action">
        <i class="bi bi-file-earmark-text me-1"></i> Posts
    </a>
    <a href="index-category.php" class="<?= $currentPage == 'index-category.php' ? 'active' : '' ?> list-group-item list-group-item-action"> 
        <i class="bi bi-tags me-1"></i> Categories
    </a>
    <a href="#" class="list-group-item list-group-item-action">
        <i class="bi bi-people me-1"></i>Users
    </a>
    <a href="#" class="list-group-item list-group-item-action ">
        <i class="bi bi-chat-left me-1"></i> Comments
    </a>
    <a href="#" class="list-group-item list-group-item-action "> 
        <i class="bi bi-person me-1"></i> Profile
    </a>
    <a href="../logout.php" class="list-group-item list-group-item-action "> 
        <i class="bi bi-box-arrow-left me-1"></i> Logout
    </a>
</div>