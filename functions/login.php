<?php
include_once 'connection.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $username;
    $_SESSION['type'] = $user['type'];
    $_SESSION['id'] = $user['id'];
    if (isset($_POST['remember'])) {
        setcookie('username', $username, time() + (86400 * 30), "/");
        setcookie('password', $password, time() + (86400 * 30), "/");
    } else {
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
    }
    generate_logs('Login', $username.'| Logged in');
    header('location: ../index.php');
} else {
    header('location: ../login.php?type=error&message=Wrong username or password');
}
