<!DOCTYPE html>
<head>
    <title>ExTracks Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <!-- SIGN UP FORM -->
    <div class="container">
        <div class="login-card">
            <h2>Sign up</h2>

            <form method="POST" action="register_process.php">
                <div class="input-group">
                    <span>👤</span>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <span>✉️</span>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <span>🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button class="login-btn" type="submit">CREATE</button>

                <p class="createaccount">
                    Already have an account?
                    <a href="login.php">Login</a>
                </p>
            </form>
            <div class="hero-platform"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>