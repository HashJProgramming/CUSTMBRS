<?php
include_once 'connection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$sql = "SELECT * FROM users WHERE username = :username OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../users.php?type=error&message='.$username.' or '.$phone.' is already exist');
    exit();
}

$sql = "INSERT INTO users (`username`, `password`, `address`, `phone`, `type`) VALUES (:username, :password, :address, :phone, 'staff')";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

generate_logs('Adding user', $fullname.'| New user was added');
header('Location: ../users.php?type=success&message=New user was added successfully');
?>