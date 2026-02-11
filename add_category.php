<?php
require "config.php";

$category = trim($_POST['category_name']);
$user_id  = $_SESSION['user_id'];

if ($category === "") {
    header("Location: categories.php");
    exit;
}

$stmt = mysqli_prepare($conn,
    "INSERT INTO category (user_id, category_name) VALUES (?, ?)"
);
mysqli_stmt_bind_param($stmt, "is", $user_id, $category);
mysqli_stmt_execute($stmt);

header("Location: categories.php");
exit;
