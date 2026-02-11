<?php
session_start();
$error = isset($_GET['error']) ? $_GET['error'] : 0;
?>

<!DOCTYPE html>
<head>
    <title>ExTracks Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="registration.php">Sign up</a></li>
        </ul>
    </nav>

    <!-- LOGIN FORM -->
    <div class="container">
        <div class="login-card">
            <h2>Login</h2>

            <form method="POST" action="login_process.php">
                <div class="input-group">
                    <span>✉️</span>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <?php if ($error): ?>
                <p class="error-msg">Invalid email or password.</p>
                <?php endif; ?>

                <button class="login-btn" type="submit">LOG IN</button>

                <p class="create">
                    <a href="registration.php">Create Account</a>
                </p>
            </form>
            <div class="hero-platform"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>