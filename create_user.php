<?php
$mysqli = new mysqli("localhost", "root", "", "tokyotable");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = "admin";  // change if you want
$password = "1234";   // change password as you want
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    echo "User '$username' created successfully!";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$mysqli->close();
?>
