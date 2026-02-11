<?php
$host = "sql301.infinityfree.com";
$user = "if0_41128594";
$pass = "extracks12345";
$db   = "if0_41128594_extracks_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();