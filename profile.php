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
        <h4 class="username"><?= htmlspecialchars($_SESSION['user_name']) ?></h4>
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="categories.php" class="nav-link">Categories</a>
        <a href="budget.php" class="nav-link">Budget</a>
        <a href="profile.php" class="nav-link active">Pofile</a>
    </aside>

    <main class="profile-content">
        <div class="profile-card">
            <h2>Profile</h2>

            <div class="profile"><img src="coin.png" alt="Profile Logo"></div>

            <p class="profile-quote">A goal without a plan is just a wish. Start tracking your expenses today!</p>

            <h1 class="name"><?= htmlspecialchars($_SESSION['user_name']) ?></h1>
            <p class="email"><?= htmlspecialchars($_SESSION['user_email']) ?></p>

            <form method="POST" action="logout.php">
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
    </main>
</div>

    <script src="script.js"></script>
</body>
</html>
