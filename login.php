<?php

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
            header("Location: http://localhost:5500/profile.html");
            return;
    }
    else 
        echo "password doesn't match";
}

else {
    echo "username not found";
}
