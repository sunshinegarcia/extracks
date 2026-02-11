<?php
// Include database connection
include 'config.php';

$error_message = "";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM expense WHERE expense_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: admin_expenses.php"); // refresh after delete
        exit();
    } else {
        $error_message = "Error deleting expense: " . $stmt->error;
        $stmt->close();
    }
}

// Fetch all expenses with user and category info
$query = "
    SELECT e.expense_id, e.expense_name, e.expense_amount, e.expense_date,
           u.user_name, u.user_email,
           c.category_name
    FROM expense e
    JOIN user u ON e.user_id = u.user_id
    JOIN category c ON e.category_id = c.category_id
    ORDER BY e.expense_id DESC
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
        <a href="admin_expenses.php" class="nav-link active">Expenses</a>
        <a href="admin_budget.php" class="nav-link">Budget</a>
        <a href="admin_categories.php" class="nav-link">Categories</a>
        <a href="admin_profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="welcome">
            <h1>MANAGE EXPENSES</h1>
        </div>

        <?php if (!empty($error_message)) { ?>
            <div class="error-message" style="color:red; margin-bottom:15px;">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <div class="categories-card">
            <h2 class="categories-subtitle">Expense List</h2>

            <div class="categories-table">
                <div class="categories-table-header table-6col">
                    <span>ID</span>
                    <span>User</span>
                    <span>Email</span>
                    <span>Name</span>
                    <span>Category</span>
                    <span>Amount</span>
                    <span>Date</span>
                    <span>Action</span>
                </div>

                <div class="categories-table-body">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="categories-table-row table-8col">
                            <span><?php echo $row['expense_id']; ?></span>
                            <span><?php echo htmlspecialchars($row['user_name']); ?></span>
                            <span><?php echo htmlspecialchars($row['user_email']); ?></span>
                            <span><?php echo htmlspecialchars($row['expense_name']); ?></span>
                            <span><?php echo htmlspecialchars($row['category_name']); ?></span>
                            <span><?php echo number_format($row['expense_amount'], 2); ?></span>
                            <span><?php echo $row['expense_date']; ?></span>
                            <span>
                                <a href="admin_expenses.php?delete_id=<?php echo $row['expense_id']; ?>" 
                                    class="category-delete"
                                   onclick="return confirm('Are you sure you want to delete this expense?');">
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
