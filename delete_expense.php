<?php
require "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$expense_id = intval($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "DELETE FROM expense WHERE expense_id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $expense_id, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: expenses.php");
exit;
