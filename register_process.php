<?php
require "config.php";

$fullname = $_POST['fullname'];
$email    = $_POST['email'];
$password = $_POST['password'];

$hashed = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$check = mysqli_prepare($conn, "SELECT user_id FROM user WHERE user_email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    die("Email already registered.");
}

// Insert user
$stmt = mysqli_prepare($conn, "
    INSERT INTO user (user_name, user_email, user_password_hash)
    VALUES (?, ?, ?)
");
mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $hashed);
mysqli_stmt_execute($stmt);

header("Location: login.php");
exit;