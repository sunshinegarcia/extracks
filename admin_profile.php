<?php
session_start();

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
        <h4 class="username">Admin</h4>
        <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
        <a href="admin_users.php" class="nav-link">Users</a>
        <a href="admin_expenses.php" class="nav-link">Expenses</a>
        <a href="admin_budget.php" class="nav-link">Budget</a>
        <a href="admin_categories.php" class="nav-link">Categories</a>
        <a href="admin_profile.php" class="nav-link active">Profile</a>
    </aside>

    <main class="profile-content">
        <div class="profile-card">
            <h2>Profile</h2>

            <div class="profile"><img src="admin.png" alt="Admin Logo"></div>

            <h1 class="name">Admin</h1>

            <form method="POST" action="logout.php">
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
    </main>
</div>

    <script src="script.js"></script>
</body>
</html>
