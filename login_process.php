<?php
require "config.php";

$email    = $_POST['email'];
$password = $_POST['password'];

$stmt = mysqli_prepare($conn, "
    SELECT user_id, user_name, user_password_hash, role
    FROM user
    WHERE user_email = ? AND user_status = 'active'
");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['user_password_hash'])) {

        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['role']      = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    }
}

header("Location: login.php?error=1");
exit;