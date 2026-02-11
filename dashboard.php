<?php
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$fullName  = $_SESSION['user_name'];
$firstName = explode(" ", $fullName)[0];
$user_id   = $_SESSION['user_id'];

// --- TODAY'S EXPENSES ---
$todayDate = date('Y-m-d');
$stmt = mysqli_prepare($conn, "
    SELECT SUM(expense_amount) 
    FROM expense 
    WHERE user_id = ? AND expense_date = ?
");

mysqli_stmt_bind_param($stmt, "is", $user_id, $todayDate);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $todayTotal);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$todayTotal = $todayTotal ?? 0;

// --- TOTAL EXPENSES ---
$stmt = mysqli_prepare($conn, "
    SELECT SUM(expense_amount) 
    FROM expense 
    WHERE user_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $overallTotal);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$overallTotal = $overallTotal ?? 0;

// --- TOTAL BUDGET ---
$stmt = mysqli_prepare($conn, "
    SELECT SUM(budget_amount) 
    FROM budget 
    WHERE user_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $totalBudget);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$totalBudget = $totalBudget ?? 0;

// Remaining budget = total budget - overall expenses
$remainingBudget = $totalBudget - $overallTotal;
if ($remainingBudget < 0) $remainingBudget = 0;

// --- TOTAL CATEGORIES ---
$stmt = mysqli_prepare($conn, "
    SELECT COUNT(*) 
    FROM category 
    WHERE user_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $totalCategories);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$totalCategories = $totalCategories ?? 0;
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
        <a href="dashboard.php" class="nav-link active">Dashboard</a>
        <a href="categories.php" class="nav-link">Categories</a>
        <a href="budget.php" class="nav-link">Budget</a>
        <a href="profile.php" class="nav-link">Profile</a>
    </aside>
 
    <!-- CONTENT -->
    <main class="content">
 
        <!-- HEADER -->
        <div class="welcome">
            <h1>WELCOME BACK, <span class="first-name"><?= htmlspecialchars($firstName) ?></span></h1>
            <p>Let’s check how much you spent!</p>
        </div>
 
        <!-- ADMIN STATS GRID -->
        <div class="user-stats-grid">
 
            <div class="user-card card-red">
                <small>TODAY’S EXPENSE</small>
                <h2>₱<?= number_format($todayTotal, 2) ?></h2>
            </div>

            <div class="user-card card-dark-red">
                <small>TOTAL EXPENSES</small>
                <h2>₱<?= number_format($overallTotal, 2) ?></h2>
            </div>

            <div class="user-card card-yellow">
                <small>REMAINING BUDGET</small>
                <h2>₱<?= number_format($remainingBudget, 2) ?></h2>
            </div>

            <div class="user-card card-purple">
                <small>TOTAL CATEGORIES</small>
                <h2><?= $totalCategories ?></h2>
            </div>

            <!-- ACTIONS -->
            <div class="actions">
                <button class="add-btn" onclick="openExpenseModal()">＋ Add Expense</button>
                <a href="expenses.php" class="view-btn">👁 View Expense</a>
            </div>
        </div>
    </main>
</div>
 
    <!-- ADD EXPENSE MODAL -->
    <div class="expense-modal-overlay" id="expenseModal">
        <div class="expense-modal">
            <h3>Add New Expense</h3>
 
            <label for="expenseName">Expense Name</label>
            <input type="text" id="expenseName" placeholder="Enter expense name">
 
            <label for="expenseAmount">Amount</label>
            <input type="number" id="expenseAmount" placeholder="₱0.00">
 
            <label for="expenseDate">Date</label>
            <input type="date" id="expenseDate">
 
            <label for="expenseCategory">Category</label>
            <select id="expenseCategory">
                <option value="">Select Category</option>
 
                    <?php
                    $catQuery = mysqli_query($conn, "SELECT category_id, category_name FROM category WHERE user_id = '{$_SESSION['user_id']}'");
 
                        while($cat = mysqli_fetch_assoc($catQuery)) {
                        echo "<option value='{$cat['category_id']}'>{$cat['category_name']}</option>";
                            }
                    ?>
            </select>
 
 
            <div class="expense-modal-buttons">
                <button type="button" class="cancel" onclick="closeExpenseModal()">Cancel</button>
                <button type="button" class="add" onclick="saveExpense()">Add</button>
            </div>
        </div>
    </div>
 
        <script src="script.js"></script>
        <script src="addexpense.js"></script>
    </body>
</html>
 