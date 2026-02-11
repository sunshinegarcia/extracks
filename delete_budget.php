<?php
require "config.php";

$id = $_GET['id'];

$stmt = mysqli_prepare($conn,
    "DELETE FROM budget WHERE budget_id = ? AND user_id = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);

header("Location: budget.php");
exit;