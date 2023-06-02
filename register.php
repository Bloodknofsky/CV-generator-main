<!DOCTYPE html>
<html>

<head>
    <title>CV Generator - Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="register.php" method="post" nonvalidate>
            <h1>CV Generator</h1>
            <h2>Register</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="number" id="phone_number" name="phone_number" placeholder="Enter your phone number">
            </div>
            <button type="submit">Register</button>
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
    
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }
    
    if (strlen($_POST["password"]) < 6) {
        die("Password must be at least 6 characters");
    }
    
    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }
    
    if (!preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }
    
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Passwords must match");
    }

    if (empty($_POST["phone_number"])) {
        die("Phone number is required");
    }
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $mysqli = require __DIR__ . "/database.php";
    
    // $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    
    // $stml = $mysqli->stmt_init();
    
    // if (!$stml->prepare($sql)) {
    //     die("SQL error: " . $mysqli->error);
    // }
    
    $id = uniqid();
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    
    $stmt = $mysqli->prepare("INSERT INTO cv_gen.users (id, username, email, phone_number, password_hash) VALUES ('$id', '$username', '$email', '$phone_number','$password_hash')");
    
    // $stmt->bindParam(':id', 1);
    // $stmt->bindParam(':username', $_POST["username"]);
    // $stmt->bindParam(':email', $_POST["email"]);
    // $stmt->bindParam(':password_hash', $password_hash);
    if($stmt->execute()) {
        header("Location: http://localhost:5500/login.php");
        return;
    }
    
}
?>
