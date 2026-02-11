<<?php
// Include database connection
include 'config.php';

$error_message = "";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Check if category is linked to any expense
    $check = $conn->prepare("SELECT COUNT(*) FROM expense WHERE category_id = ?");
    $check->bind_param("i", $delete_id);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // Category has linked expenses
        $error_message = "Cannot delete this category because it is linked to one or more expenses.";
    } else {
        // Safe to delete
        $stmt = $conn->prepare("DELETE FROM category WHERE category_id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: admin_categories.php"); // refresh after delete
            exit();
        } else {
            $error_message = "Error deleting category: " . $stmt->error;
            $stmt->close();
        }
    }
}

// Fetch all categories with user info
$query = "
    SELECT c.category_id, c.category_name, c.category_created_at,
           u.user_name, u.user_email
    FROM category c
    LEFT JOIN user u ON c.user_id = u.user_id
    ORDER BY c.category_id DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ExTracks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <div class="logo">ExTracks</div>
</header>

<div class="layout">
    <aside class="sidebar">
        <div class="profile"><img src="money-character.png" alt="Profile Logo"></div>
        <h4 class="username">Admin</h4>
        <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
        <a href="admin_users.php" class="nav-link">Users</a>
        <a href="admin_expenses.php" class="nav-link">Expenses</a>
        <a href="admin_budget.php" class="nav-link">Budget</a>
        <a href="admin_categories.php" class="nav-link active">Categories</a>
        <a href="admin_profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="welcome">
            <h1>MANAGE CATEGORIES</h1>
        </div>

        <?php if (!empty($error_message)) { ?> 
            <div class="error-message" style="color:red; margin-bottom:15px;"> 
                <?php echo $error_message; ?> 
            </div> 
        <?php } ?>

        <div class="categories-card">
            <h2 class="categories-subtitle">Category List</h2>

            <div class="categories-table">
                <div class="categories-table-header table-4col">
                    <span>ID</span>
                    <span>Name</span>
                    <span>User</span>
                    <span>Action</span>
                </div>

                <div class="categories-table-body">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="categories-table-row table-4col">
                            <span><?php echo $row['category_id']; ?></span>
                            <span><?php echo htmlspecialchars($row['category_name']); ?></span>
                            <span>
                                <?php 
                                    if ($row['user_name']) {
                                        echo htmlspecialchars($row['user_name']) . " (" . htmlspecialchars($row['user_email']) . ")";
                                    } else {
                                        echo "System / Admin";
                                    }
                                ?>
                            </span>
                            <span>
                                <a href="admin_categories.php?delete_id=<?php echo $row['category_id']; ?>" 
                                    class="category-delete"
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                   Delete
                                </a>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="script.js"></script>
</body>
</html>
