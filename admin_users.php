<?php
// admin_users.php
include 'config.php'; // your DB connection file

// Fetch all users
$sql = "SELECT user_id, user_name, user_email FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
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
        <a href="admin_users.php" class="nav-link active">Users</a>
        <a href="admin_expenses.php" class="nav-link">Expenses</a>
        <a href="admin_budget.php" class="nav-link">Budget</a>
        <a href="admin_categories.php" class="nav-link">Categories</a>
        <a href="admin_profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="welcome">
            <h1>MANAGE USERS</h1>
        </div>

        <div class="categories-card">
            <h2 class="categories-subtitle">User List</h2>
            <div class="categories-table">

                <div class="categories-table-header">
                    <span>ID</span>
                    <span>User</span>
                    <span>Email</span>
                    <span>Action</span>
                </div>

                <div class="categories-table-body">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="categories-table-row">
                                <span><?php echo $row['user_id']; ?></span>
                                <span><?php echo htmlspecialchars($row['user_name']); ?></span>
                                <span><?php echo htmlspecialchars($row['user_email']); ?></span>
                                <span>
                                    <form method="POST" action="delete_user.php" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <button type="submit" class="category-delete" onclick="return confirm('Delete this user?');">Delete</button>
                                    </form>
                                </span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No users found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="script.js"></script>
</body>
</html>
