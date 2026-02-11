<?php
session_start();
require "config.php";

mysqli_query($conn,
    "DELETE FROM budget WHERE user_id=" . $_SESSION['user_id']
);

header("Location: budget.php");
exit;
