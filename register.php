<?php

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


$stmt = $mysqli->prepare("INSERT INTO cv_gen.users (id, username, email, password_hash) VALUES ('$id', '$username', '$email', '$password_hash')");

// $stmt->bindParam(':id', 1);
// $stmt->bindParam(':username', $_POST["username"]);
// $stmt->bindParam(':email', $_POST["email"]);
// $stmt->bindParam(':password_hash', $password_hash);
if($stmt->execute()) {
    header("Location: http://localhost:5500/login.html");
    return;
}

