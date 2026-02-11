<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<head>
    <title>ExTracks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dark">

    <!-- NAVBAR -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php" class="nav-link">Home</a></li>
            <li><a href="#features" class="nav-link">Features</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="login.php" class="nav-link">Login</a></li>
            <li><a href="registration.php">Sign up</a></li>
        </ul>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">

        <!-- LEFT CONTENT -->
        <div class="hero-left">
            <div class="content">
                <div class="logo-circle"></div>

                <p class="tagline">
                    Track your expenses easily. Stay smart with your money
                </p>

                <h1>ExTracks</h1>

                <a href="registration.php">
                    <button id="getStartedBtn">GET STARTED</button>
                </a>
                    <div class="button-circles">
                        <div class="circle"></div>
                    </div>
                    <div class="button-circles1">
                        <div class="circle1"></div>
                    </div>
                    <div class="button-circles2">
                        <div class="circle2"></div>
                    </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="hero-right">
            <div class="hero-circle"></div>
            <img src="money-character.png" alt="Money Character">
        </div>

        <!-- BOTTOM PLATFORM -->
        <div class="hero-platform"></div>

    </section>


    <!-- DESCRIPTION -->
    <section class="description">
        <p>
            ExTracks is your smart daily expense tracker that helps you easily monitor your spending, stay on budget, and take control of your finances—all in one simple and intuitive app.
        </p>
    </section>

    <!-- FEATURES TITLE -->
    <div class="section-title" id="features">
        FEATURES
    </div>

    <!-- FEATURES SECTION -->
    <section class="features">
        <div class="feature-card">
            <h3>Track Expense</h3>
            <img src="expense.png" alt="Track Expense">
            <p>
                Easily record your daily expenses and categorize them to see exactly where your money goes.
            </p>
        </div>

        <div class="feature-card">
            <h3>Reports</h3>
            <img src="reports.png" alt="Reports">
            <p>
                Visualize your spending with summaries, making it simple to understand your financial habits.
            </p>
        </div>

        <div class="feature-card">
            <h3>Budgets</h3>
            <img src="budgets.png" alt="Budgets">
            <p>
                Set budgets for different categories and stay on top of your finances without overspending.
            </p>
        </div>
    </section>

    <!-- ABOUT TITLE -->
    <div class="section-title">
        ABOUT
    </div>

    <!-- ABOUT SECTION -->
    <section class="about" id="about">
        <div class="about-text">
            <h2>Our Team</h2>
            <p>
                Our team is dedicated to designing innovative and user-friendly solutions that simplify financial management for everyone. With a shared passion for technology, creativity, and collaboration, we work together to create tools that empower users to take control of their finances. The following are the talented members who make it all possible.
            </p>
        </div>
    </section>

    <section class="teamphoto">
        <div class="member-card">
            <img src="shine.png" alt="Photo">
            <h3>Sunshine Garcia</h3>
            <p>
                Frontend Developer
            </p>
        </div>

        <div class="member-card">
            <img src="rj.png" alt="Photo">
            <h3>Ruel Nalda Jr.</h3>
            <p>
                Team Leader
            </p>
        </div>

        <div class="member-card">
            <img src="cesia.png" alt="Photo">
            <h3>Princess Felix</h3>
            <p>
                Database & Backend
            </p>
        </div>

        <div class="member-card">
            <img src="jas.png" alt="Photo">
            <h3>Raizel Mosura</h3>
            <p>
                Graphic Designer
            </p>
        </div>

        <div class="member-card">
            <img src="charles.png" alt="Photo">
            <h3>Charles Dy</h3>
            <p>
                Database & Backend
            </p>
        </div>

       </section> 

    <script src="script.js"></script>
</body>
</html>
