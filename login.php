<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="login.php" method="post" nonvalidate>
            <h1>CV Generator</h1>
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Login</button>
            <div class="register-link">
                Don't have an account? <a href="register.php">Create new account</a>
            </div>
        </form>
    </div>
    <footer>
        <p>&copy; 2023 CV Generator. All rights reserved.</p>
    </footer>
</body>

</html>

<?php

if (sizeof($_POST) > 0) {
    if (empty($_POST["username"])) {
        die("Username is required");
    }
    
    $password_hash = $_POST["password"];
    
    $mysqli = require __DIR__ . "/database.php";
    
    // $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    
    // $stml = $mysqli->stmt_init();
    
    // if (!$stml->prepare($sql)) {
    //     die("SQL error: " . $mysqli->error);
    // }
    
    $username = $_POST["username"];
    
    $stmt = $mysqli->query("SELECT * FROM users WHERE username='$username'");
    
    // $stmt->bindParam(':id', 1);
    // $stmt->bindParam(':username', $_POST["username"]);
    // $stmt->bindParam(':email', $_POST["email"]);
    // $stmt->bindParam(':password_hash', $password_hash);
    
    // $user = $stmt->execute();
    
    if (mysqli_num_rows($stmt) !== 0) {
        $row = mysqli_fetch_assoc($stmt);
        $dbpassword = $row['password_hash'];
        if (password_verify($password_hash, $dbpassword)) {
            //    echo json_encode(["data" => "baal to go!", "error" => ""]);
                header("Location: http://localhost:5500/profile.php");
                setcookie("id", $row['id'], time() + (86400 * 30), "/");
                return;
        }
        else 
            echo "password doesn't match";
    }
    
    else {
        echo "username not found";
    }
}


?>