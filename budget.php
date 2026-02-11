<?php
require "config.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

/* FETCH BUDGETS */
$stmt = mysqli_prepare($conn, "
    SELECT 
        b.budget_id,
        b.category_id,
        b.budget_amount,
        b.budget_period,
        b.budget_start_date,
        b.budget_end_date,
        c.category_name
    FROM budget b
    JOIN category c ON b.category_id = c.category_id
    WHERE b.user_id = ?
    ORDER BY b.budget_id DESC
");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile"><img src="money-character.png" alt="Profile Logo"></div>
        <h4 class="username"><?= $_SESSION['user_name'] ?></h4>
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="categories.php" class="nav-link">Categories</a>
        <a href="budget.php" class="nav-link active">Budget</a>
        <a href="profile.php" class="nav-link">Profile</a>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <div class="welcome">
            <h1>BUDGET MANAGEMENT</h1>
        </div>

        <div class="categories-card">
            <h2 class="categories-subtitle">Budgets</h2>

            <div class="categories-table">
                <div class="categories-table-header">
                    <span>Category</span>
                    <span>Amount</span>
                    <span>Period</span>
                    <span>Action</span>
                </div>

                <div class="budget-table-body">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="categories-row">
                        <span><?= htmlspecialchars($row['category_name']) ?></span>
                        <span>₱<?= number_format($row['budget_amount'], 2) ?></span>
                        <span><?= ucfirst($row['budget_period']) ?></span>
                        <span>
                            <button class="edit-btn"
                                onclick="editBudget(
                                    <?= $row['budget_id'] ?>,
                                    <?= $row['category_id'] ?>,
                                    <?= $row['budget_amount'] ?>,
                                    '<?= $row['budget_period'] ?>',
                                    '<?= $row['budget_start_date'] ?>',
                                    '<?= $row['budget_end_date'] ?>'
                                )">Edit</button>

                            <a href="delete_budget.php?id=<?= $row['budget_id'] ?>"
                                class="budget-delete"
                                onclick="return confirm('Delete this budget?')">
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
            <button class="budget-icon-btn" onclick="openModal()">➕</button>
        </div>

    </main>
</div>

<!-- ADD / EDIT BUDGET MODAL -->
<div class="budget-modal-overlay" id="budget_modal">
    <div class="budget-modal">
        <h3>Add Budget</h3>

        <form action="add_budget.php" method="POST" class="budget-form">
            <input type="hidden" name="budget_id" id="budget_id">

            <label>Category</label>
            <select id="budget_category" name="budget_category" required>
                <option value="">-- Select Category --</option>
                <?php
                $cats = mysqli_prepare($conn,
                    "SELECT category_id, category_name FROM category WHERE user_id = ?"
                );
                mysqli_stmt_bind_param($cats, "i", $_SESSION['user_id']);
                mysqli_stmt_execute($cats);
                $catRes = mysqli_stmt_get_result($cats);

                while ($cat = mysqli_fetch_assoc($catRes)):
                ?>
                    <option value="<?= $cat['category_id'] ?>">
                        <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Amount</label>
            <input type="number" name="budget_amount" id="budget_amount" required>

            <label>Period</label>

            <div class="radio-group">
                <label><input type="radio" name="budget_period" value="weekly"> Weekly</label>
                <label><input type="radio" name="budget_period" value="monthly" checked> Monthly</label>
                <label><input type="radio" name="budget_period" value="daily"> Daily</label>
            </div>

            <label>Start Date</label>
            <input type="date" name="budget_start_date" id="budget_start_date" required>

            <label>End Date</label>
            <input type="date" name="budget_end_date" id="budget_end_date" required>

            <div class="budget-modal-buttons">
                <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="save_budget">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="budget.js"></script>
</body>
</html>