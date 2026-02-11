<?php
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<head>
    <title>ExTracks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- TOP NAV -->
<header class="topbar">
    <div class="logo">ExTracks</div>
</header>

<!-- MAIN LAYOUT -->
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile"><img src="money-character.png" alt="Profile Logo"></div>
        <h4 class="username"><?= $_SESSION['user_name'] ?></h4>
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="categories.php" class="nav-link active">Categories</a>
        <a href="budget.php" class="nav-link">Budget</a>
        <a href="profile.php" class="nav-link">Profile</a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message" style="color:red; margin-bottom:15px;">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="welcome">
            <h1>CATEGORIES MANAGEMENT</h1>
        </div>

        <div class="categories-card">
            <h2 class="categories-subtitle">Categories List</h2>

            <div class="categories-table">
                <div class="categories-table-header">
                    <span>Category Name</span>
                    <span>Actions</span>
                </div>

                <div class="categories-table-body">
                <?php
                $stmt = mysqli_prepare($conn,
                    "SELECT category_id, category_name FROM category WHERE user_id = ?"
                );
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <div class="categories-table-row">
                        <span><?= htmlspecialchars($row['category_name']) ?></span>
                        <span>
                            <a href="delete_category.php?id=<?= $row['category_id'] ?>"
                                class="category-delete"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </span>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>

        <div class="categories-bottom-actions">
            <a href="dashboard.php" class="categories-back">Back</a>
            <button class="categories-icon-btn" onclick="openModal()">➕</button>
        </div>
    </main>

</div>

<!-- ADD CATEGORY MODAL -->
<div class="categories-modal-overlay" id="modal">
    <div class="category-modal">
        <h3>Add New Category</h3>

        <form action="add_category.php" method="POST">
            <label>Category Name</label>
            <input type="text" name="category_name" id="categoryInput" required>

            <div class="category-modal-buttons">
                <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="add">Add</button>
            </div>
        </form>
    </div>
</div>

<script src="categories.js"></script>
</body>
</html>
