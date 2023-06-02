<!DOCTYPE html>
<html>
    <head>
        <title>CV Generator - Generate CV</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="generate_cv.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="generate_cv.php">Generate CV</a></li>
                    <li><a href="profile.php">User Profile</a></li>
                    <li><a href="help.html">Help</a></li>
                    <li><a href="?logout" onclick="LogoutButtonClicked()">Logout</a></li>
                </ul>
            </nav>
        </header>
    </body>
    <main>
        <section class="recent-cv">
            <div class="container">
                <h2>Your Recent CV</h2>
                <div class="cv-preview">
                    <img src="https://th.bing.com/th/id/OIP.ObywAhAjDrQrVP9R5GY4PwHaHa?pid=ImgDet&rs=1"
                        alt="CV preview">
                </div>
                <div class="cta-btns">
                    <a href="generate_cv.php" class="cta-btn">Edit CV</a>
                    <a href="#" class="cta-btn cta-btn-secondary">Download as PDF</a>
                </div>
            </div>
        </section>
    </main>
</html>

<?php
    if (!isset($_COOKIE["id"])) {
        header("Location: http://localhost:5500/homepage.html");
        exit();
    } else {
        if (isset($_GET['logout'])) {
    
            setcookie("id", "", time() - 3600);
    
            header('Location: http://localhost:5500/login.php');
    
            exit;
        }
    }
?>