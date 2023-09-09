<?php
include_once 'connection.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
$current = $_POST['current'];
$new = $_POST['new'];
$id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($current, $user['password'])) {
 
    $sql = "UPDATE users SET password = :new WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':new', password_hash($new, PASSWORD_DEFAULT));
    $statement->execute();

    generate_logs('Change Password', $user['username'].'| Password was updated');
    header('Location: ../index.php?type=success&message=Password was updated successfully!');
    exit();
} else {
    header('location: ../index.php?type=error&message=Wrong password');
    exit();
}
?>