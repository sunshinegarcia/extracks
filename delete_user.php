<?php
include 'config.php';

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $sql = "DELETE FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: admin_users.php?msg=User+deleted");
    } else {
        echo "Error deleting user.";
    }
}
?>
