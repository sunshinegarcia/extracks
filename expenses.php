<?php
require "config.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all expenses for the user
$expenses = [];
$stmt = mysqli_prepare($conn, "
    SELECT e.expense_id, e.expense_name, e.expense_amount, e.expense_date, e.expense_created_at, c.category_name
    FROM expense e
    JOIN category c ON e.category_id = c.category_id
    WHERE e.user_id = ?
    ORDER BY e.expense_date DESC, e.expense_created_at DESC
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $expenses[] = $row;
}

mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ExTracks - View Expense</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <div class="logo">ExTracks</div>
</header>

<div class="layout">
    <aside class="sidebar">
        <div class="profile"><img src="money-character.png" alt="Profile Logo"></div>
        <h4 class="username"><?= htmlspecialchars($_SESSION['user_name']) ?></h4>
        <a href="dashboard.php" class="nav-link active">Dashboard</a>
        <a href="categories.php" class="nav-link">Categories</a>
        <a href="budget.php" class="nav-link">Budget</a>
        <a href="profile.php" class="nav-link">Profile</a>
    </aside>

    <main class="content">
        <div class="welcome">
            <h1>VIEW EXPENSE</h1>
        </div>

        <div class="expense-card">
            <div class="filter-row">
                <h3>Category</h3>
                <select class="category-filter" id="categoryFilter">
                    <option value="">All</option>
                    <?php
                    $catQuery = mysqli_query($conn, "SELECT category_id, category_name FROM category WHERE user_id = '$user_id'");
                    while ($cat = mysqli_fetch_assoc($catQuery)) {
                        echo "<option value='{$cat['category_name']}'>" . htmlspecialchars($cat['category_name']) . "</option>";
                    }
                    ?>
                </select>

                <h3>Date</h3>
                <input class="category-filter" type="date" id="dateFilter">
            </div>

            <div class="main-expense-card">
                <table>
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>NAME</th>
                            <th>CATEGORY</th>
                            <th>AMOUNT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <?php foreach ($expenses as $exp): ?>
                        <tr>
                            <td><?= htmlspecialchars($exp['expense_date']) ?></td>
                            <td><?= htmlspecialchars($exp['expense_name']) ?></td>
                            <td><?= htmlspecialchars($exp['category_name']) ?></td>
                            <td>₱<?= number_format($exp['expense_amount'], 2) ?></td>
                            <td>
                                <a href="edit_expense.php?id=<?= $exp['expense_id'] ?>" class="btn-edit">Edit</a>
                                <a href="delete_expense.php?id=<?= $exp['expense_id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this expense?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($expenses)): ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No expenses found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="back-btn">
                <a href="dashboard.php" class="view-back">Back</a>
            </div>
        </div>
    </main>
</div>

<script>
    const categoryFilter = document.getElementById("categoryFilter");
    const dateFilter = document.getElementById("dateFilter");
    const tableBody = document.getElementById("expenseTableBody");

    function filterExpenses() {
        const category = categoryFilter.value.toLowerCase();
        const date = dateFilter.value;

        Array.from(tableBody.getElementsByTagName("tr")).forEach(row => {
            if (row.cells.length < 5) return; // skip "No expenses found" row
            const catCell = row.cells[2].textContent.toLowerCase();
            const dateCell = row.cells[0].textContent;
            row.style.display = (
                (category === "" || catCell === category) &&
                (date === "" || dateCell === date)
            ) ? "" : "none";
        });
    }

    categoryFilter.addEventListener("change", filterExpenses);
    dateFilter.addEventListener("change", filterExpenses);
</script>

</body>
</html>
