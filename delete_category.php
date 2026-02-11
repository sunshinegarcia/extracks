<?php
require "config.php";

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check if category is linked to any expense
$check = mysqli_prepare($conn, "SELECT COUNT(*) FROM expense WHERE category_id = ? AND user_id = ?");
mysqli_stmt_bind_param($check, "ii", $id, $user_id);
mysqli_stmt_execute($check);
mysqli_stmt_bind_result($check, $count);
mysqli_stmt_fetch($check);
mysqli_stmt_close($check);

if ($count > 0) {
    // Store error message in session
    $_SESSION['error_message'] = "Cannot delete this category because it is linked to one or more expenses.";
    header("Location: categories.php");
    exit;
} else {
    // Safe to delete
    $stmt = mysqli_prepare($conn, "DELETE FROM category WHERE category_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: categories.php");
    exit;
}
