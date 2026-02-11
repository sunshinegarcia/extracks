<?php
// Include database connection
include 'config.php';

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM budget WHERE budget_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_budget.php"); // refresh after delete
    exit();
}

// Fetch all budgets with user info
$query = "
    SELECT b.budget_id, b.budget_amount, b.budget_start_date, b.budget_end_date,
           b.budget_period, u.user_name, u.user_email
    FROM budget b
    JOIN user u ON b.user_id = u.user_id
    ORDER BY b.budget_id DESC
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
        <a href="admin_budget.php" class="nav-link active">Budget</a>
        <a href="admin_categories.php" class="nav-link">Categories</a>
        <a href="admin_profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="welcome">
            <h1>MANAGE BUDGETS</h1>
        </div>

        <div class="categories-card">
            <h2 class="categories-subtitle">Budget List</h2>

            <div class="categories-table">
                <div class="categories-table-header table-6col">
                    <span>ID</span>
                    <span>User</span>
                    <span>Email</span>
                    <span>Amount</span>
                    <span>Period</span>
                    <span>Action</span>
                </div>

                <div class="categories-table-body">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="categories-table-row table-6col">
                            <span><?php echo $row['budget_id']; ?></span>
                            <span><?php echo htmlspecialchars($row['user_name']); ?></span>
                            <span><?php echo htmlspecialchars($row['user_email']); ?></span>
                            <span><?php echo number_format($row['budget_amount'], 2); ?></span>
                            <span><?php echo ucfirst($row['budget_period']); ?> 
                                  (<?php echo $row['budget_start_date']; ?> - <?php echo $row['budget_end_date']; ?>)</span>
                            <span>
                                <a href="admin_budget.php?delete_id=<?php echo $row['budget_id']; ?>"
                                    class="category-delete"
                                   onclick="return confirm('Are you sure you want to delete this budget?');">
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
