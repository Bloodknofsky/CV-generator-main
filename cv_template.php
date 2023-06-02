<!DOCTYPE html>
<html>
<head>
    <title>CV Generator - Choose Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="choose_template.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="profile.php">User Profile</a></li>
                <li><a href="?logout" onclick="LogoutButtonClicked()">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="cv-templates">
            <div class="container">
                <h2>Choose a CV Template</h2>
                <div class="templates-grid">
                    <div class="template">
                        <img src="/temp_img/temp01.png" alt="Template 1" width="790" height="380">
                        <li><a href="template01.php">Template 01</a></li>
                    </div>
                    <div class="template">
                        <img src="/temp_img/temp02.png" alt="Template 2" width="790" height="380">
                        <li><a href="template02.php">Template 02</a></li>
                    </div>
                    <div class="template">
                        <img src="/temp_img/temp03.png" alt="Template 3" width="790" height="380">
                        <li><a href="template03.php">Template 03</a></li>
                    </div>
                    <div class="template">
                        <img src="/temp_img/temp04.png" alt="Template 4" width="790" height="380">
                        <li><a href="template04.php">Template 04</a></li>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2023 CV Generator. All rights reserved.</p>
        </div>
    </footer>
</body>
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