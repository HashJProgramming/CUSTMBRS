<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET `username` = :username, `password` = :password, `address` = :address, `phone` = :phone WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':phone', $phone);
    $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
    $statement->execute();

    generate_logs('Staff Update', $username.'| Info was updated');
    header('Location: ../users.php?type=success&message=Staff Info was updated successfully!');
    exit();

} catch (\Throwable $th) {
    generate_logs('Customer Update', $username.'| Error: '.$th->getMessage());
}
?>