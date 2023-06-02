<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="generate_cv.php">Generate CV</a></li>
                <li><a href="cv_preview.php">CV Preview</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
                <li><a href="help.html">Help</a></li>
                <li><a href="?logout" onclick="LogoutButtonClicked()">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="profile">
            <div class="container">
                <h2>User Profile</h2>
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="https://media.licdn.com/dms/image/C5603AQEpRI58sTuyUg/profile-displayphoto-shrink_800_800/0/1587624944487?e=2147483647&v=beta&t=va-UvCAfHZri7kkEDMZ16CMuEPBTFi-b9EmL11xZRz8"
                            alt="Profile picture">
                    </div>
                    <div class="profile-details">
                        <?php 
                            $mysqli = require __DIR__ . "/database.php";
                            $id = $_COOKIE["id"];
                            $stmt = $mysqli->query("SELECT * FROM users WHERE id='$id'");
                            if (mysqli_num_rows($stmt) !== 0) {
                                $row = mysqli_fetch_assoc($stmt);
                                echo "<h3>".$row["username"]."</h3>
                                <p>Email: ".$row["email"]."</p>
                                <p>Phone: ".$row["phone_number"]."</p>";
                            }
                            
                        ?>
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