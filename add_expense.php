<?php
require "config.php";
session_start();

header('Content-Type: application/json');

// Prevent accidental output before JSON
ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in."]);
    exit;
}

$user_id       = $_SESSION['user_id'];
$expense_name  = trim($_POST['expense_name'] ?? '');
$expense_amount = floatval($_POST['expense_amount'] ?? 0);
$expense_date  = $_POST['expense_date'] ?? '';
$category_id   = intval($_POST['category_id'] ?? 0);

// 1. Input validation
if (!$expense_name || !$expense_amount || !$expense_date || !$category_id) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// 2. Check budget for this category
$stmt = mysqli_prepare($conn, "
    SELECT budget_amount, budget_period, budget_start_date, budget_end_date
    FROM budget
    WHERE user_id = ? AND category_id = ? AND ? BETWEEN budget_start_date AND budget_end_date
");
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Prepare failed: " . mysqli_error($conn)]);
    exit;
}
mysqli_stmt_bind_param($stmt, "iis", $user_id, $category_id, $expense_date);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $budget_amount_db, $budget_period, $start_date, $end_date);

if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    echo json_encode(["status" => "error", "message" => "No active budget for this category on selected date."]);
    exit;
}
mysqli_stmt_close($stmt);

$budget_amount = floatval($budget_amount_db);

// 3. Determine period range
switch ($budget_period) {
    case 'daily':
        $period_start = $expense_date;
        $period_end   = $expense_date;
        break;
    case 'weekly':
        $period_start = date('Y-m-d', strtotime('monday this week', strtotime($expense_date)));
        $period_end   = date('Y-m-d', strtotime('sunday this week', strtotime($expense_date)));
        break;
    case 'monthly':
        $period_start = date('Y-m-01', strtotime($expense_date));
        $period_end   = date('Y-m-t', strtotime($expense_date));
        break;
    default:
        $period_start = $expense_date;
        $period_end   = $expense_date;
}

// 4. Calculate total expenses
$stmt2 = mysqli_prepare($conn, "
    SELECT SUM(expense_amount)
    FROM expense
    WHERE user_id = ? AND category_id = ? AND expense_date BETWEEN ? AND ?
");
mysqli_stmt_bind_param($stmt2, "iiss", $user_id, $category_id, $period_start, $period_end);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $total);
mysqli_stmt_fetch($stmt2);
$total = floatval($total ?? 0);
mysqli_stmt_close($stmt2);

if (($total + $expense_amount) > $budget_amount) {
    echo json_encode(["status" => "error", "message" => "You cannot add this expense. Budget exceeded for this period."]);
    exit;
}

// 5. Insert expense (NOW includes expense_name)
$stmt3 = mysqli_prepare($conn, "
    INSERT INTO expense (user_id, category_id, expense_name, expense_amount, expense_date, expense_created_at)
    VALUES (?, ?, ?, ?, ?, NOW())
");
mysqli_stmt_bind_param($stmt3, "iisis", $user_id, $category_id, $expense_name, $expense_amount, $expense_date);
$success = mysqli_stmt_execute($stmt3);

// Capture inserted ID for Action links
$insert_id = mysqli_insert_id($conn);

mysqli_stmt_close($stmt3);

if (!$success) {
    echo json_encode(["status" => "error", "message" => "Insert failed: " . mysqli_error($conn)]);
    exit;
}

// 6. Get category name
$cat_name = 'Unknown';
$stmt4 = mysqli_prepare($conn, "SELECT category_name FROM category WHERE category_id = ?");
mysqli_stmt_bind_param($stmt4, "i", $category_id);
mysqli_stmt_execute($stmt4);
mysqli_stmt_bind_result($stmt4, $fetched_cat_name);
if (mysqli_stmt_fetch($stmt4)) {
    $cat_name = $fetched_cat_name;
}
mysqli_stmt_close($stmt4);

// 7. Return JSON (now includes expense_id)
echo json_encode([
    "status" => "success",
    "expense" => [
        "expense_id"    => $insert_id,
        "expense_name"  => $expense_name,
        "category_name" => $cat_name,
        "expense_amount"=> $expense_amount,
        "expense_date"  => $expense_date
    ]
]);
exit;
