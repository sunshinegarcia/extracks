<?php
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id    = $_SESSION['user_id'];
$expense_id = intval($_GET['id'] ?? 0);

// Fetch expense details
$stmt = mysqli_prepare($conn, "
    SELECT expense_name, expense_amount, expense_date, category_id
    FROM expense
    WHERE expense_id = ? AND user_id = ?
");
mysqli_stmt_bind_param($stmt, "ii", $expense_id, $user_id);
mysqli_stmt_execute($stmt);
$result  = mysqli_stmt_get_result($stmt);
$expense = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$expense) {
    die("Expense not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expense_name   = trim($_POST['expense_name']);
    $expense_amount = floatval($_POST['expense_amount']);
    $expense_date   = $_POST['expense_date'];
    $category_id    = intval($_POST['category_id']);

    $update = mysqli_prepare($conn, "
        UPDATE expense
        SET expense_name = ?, expense_amount = ?, expense_date = ?, category_id = ?
        WHERE expense_id = ? AND user_id = ?
    ");
    mysqli_stmt_bind_param($update, "sdsiii", $expense_name, $expense_amount, $expense_date, $category_id, $expense_id, $user_id);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);

    header("Location: expenses.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- EDIT EXPENSE MODAL -->
<div class="expense-modal-overlay" style="display:flex;">
    <div class="expense-modal">
        <h3>Edit Expense</h3>

        <form method="post">
            <label for="expenseName">Expense Name</label>
            <input type="text" id="expenseName" name="expense_name" value="<?= htmlspecialchars($expense['expense_name']) ?>" required>

            <label for="expenseAmount">Amount</label>
            <input type="number" step="0.01" id="expenseAmount" name="expense_amount" value="<?= htmlspecialchars($expense['expense_amount']) ?>" required>

            <label for="expenseDate">Date</label>
            <input type="date" id="expenseDate" name="expense_date" value="<?= htmlspecialchars($expense['expense_date']) ?>" required>

            <label for="expenseCategory">Category</label>
            <select id="expenseCategory" name="category_id" required>
                <option value="">Select Category</option>
                <?php
                $catQuery = mysqli_query($conn, "SELECT category_id, category_name FROM category WHERE user_id = '$user_id'");
                while ($cat = mysqli_fetch_assoc($catQuery)) {
                    $selected = ($cat['category_id'] == $expense['category_id']) ? "selected" : "";
                    echo "<option value='{$cat['category_id']}' $selected>" . htmlspecialchars($cat['category_name']) . "</option>";
                }
                ?>
            </select>

            <div class="expense-modal-buttons">
                <a href="expenses.php" class="cancel">Cancel</a>
                <button type="submit" class="add">Save Changes</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
