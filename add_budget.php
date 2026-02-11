<?php
session_start();
require "config.php";

$user_id = $_SESSION['user_id'];
$id = $_POST['budget_id'] ?? null;

$category = $_POST['budget_category'];
$amount = $_POST['budget_amount'];
$period = $_POST['budget_period'];
$start = $_POST['budget_start_date'];
$end = $_POST['budget_end_date'];

if ($id) {
    // UPDATE
    $stmt = mysqli_prepare($conn,
        "UPDATE budget
         SET category_id=?, budget_amount=?, budget_period=?, budget_start_date=?, budget_end_date=?
         WHERE budget_id=? AND user_id=?"
    );
    mysqli_stmt_bind_param($stmt, "idsssii",
        $category, $amount, $period, $start, $end, $id, $user_id
    );
} else {
    // INSERT
    $stmt = mysqli_prepare($conn,
        "INSERT INTO budget (user_id, category_id, budget_amount, budget_period, budget_start_date, budget_end_date)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "iidsss",
        $user_id, $category, $amount, $period, $start, $end
    );
}

mysqli_stmt_execute($stmt);
header("Location: budget.php");
exit;
