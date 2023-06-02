<?php
    if (!isset($_COOKIE["id"])) {
        header("Location: http://localhost:5500/register.php");
        return;
    } else {
        if (isset($_GET['logout'])) {
    
            setcookie("id", "", time() - 3600);
    
            header('Location: http://localhost:5500/login.php');
    
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Edit Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="generate_cv.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="profile.php">User Profile</a></li>
                <li><a href="help.html">Help</a></li>
                <li><a href="?logout" onclick="LogoutButtonClicked()">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="edit-profile">
            <div class="container">
                <h2>Edit Profile</h2>
                <form action="edit_profile.php" method="post" nonvalidate>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone">
                    <button type="submit">Save Changes</button>
                </form>
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

if (sizeof($_POST) > 0) {
    if (empty($_POST["name"])) {
        die("Username is required");
    }
    
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (empty($_POST["phone"])) {
        die("Phone number is required");
    }
    
    $mysqli = require __DIR__ . "/database.php";
    
    // $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    
    // $stml = $mysqli->stmt_init();
    
    // if (!$stml->prepare($sql)) {
    //     die("SQL error: " . $mysqli->error);
    // }
    
    $unid = $_COOKIE['id'];
    $username = $_POST["name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone"];
    
    $stmt = $mysqli->prepare("UPDATE cv_gen.users set cv_gen.users.email='$email', cv_gen.users.username='$username', cv_gen.users.phone_number='$phone_number' where cv_gen.users.id='$unid'");
    
    // $stmt->bindParam(':id', 1);
    // $stmt->bindParam(':username', $_POST["username"]);
    // $stmt->bindParam(':email', $_POST["email"]);
    // $stmt->bindParam(':password_hash', $password_hash);
    if($stmt->execute()) {
        header("Location: http://localhost:5500/profile.php");
        return;
    }
    
}
?>