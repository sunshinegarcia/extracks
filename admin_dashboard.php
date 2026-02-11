<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php';

// Fetch totals
// Total users
$userResult = $conn->query("SELECT COUNT(*) AS total_users FROM user");
$total_users = $userResult->fetch_assoc()['total_users'];

// Total categories
$catResult = $conn->query("SELECT COUNT(*) AS total_categories FROM category");
$total_categories = $catResult->fetch_assoc()['total_categories'];

// Total budgets (count)
$budgetResult = $conn->query("SELECT COUNT(*) AS total_budgets FROM budget");
$total_budgets = $budgetResult->fetch_assoc()['total_budgets'];

// Total expenses (sum of amounts)
$expenseResult = $conn->query("SELECT SUM(expense_amount) AS total_expenses FROM expense");
$total_expenses = $expenseResult->fetch_assoc()['total_expenses'];
if ($total_expenses === null) {
    $total_expenses = 0; // handle case when no expenses exist
}
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
        <a href="admin_dashboard.php" class="nav-link active">Dashboard</a>
        <a href="admin_users.php" class="nav-link">Users</a>
        <a href="admin_expenses.php" class="nav-link">Expenses</a>
        <a href="admin_budget.php" class="nav-link">Budget</a>
        <a href="admin_categories.php" class="nav-link">Categories</a>
        <a href="admin_profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="admin-welcome">
            <h1>WELCOME BACK, Admin!</h1>
            <p>Track and manage all user expenses.</p>
        </div>

        <div class="admin-stats-grid">

            <div class="admin-card card-red">
                <small>TOTAL USERS</small>
                <h2><?php echo $total_users; ?></h2>
            </div>

            <div class="admin-card card-dark-red">
                <small>TOTAL NUMBER OF BUDGETS</small>
                <h2><?php echo $total_budgets; ?></h2>
            </div>

            <div class="admin-card card-purple">
                <small>TOTAL CATEGORIES</small>
                <h2><?php echo $total_categories; ?></h2>
            </div>

        </div>
    </main>
</div>

<script src="script.js"></script>
</body>
</html>
