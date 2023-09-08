<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    $sql = "SELECT * FROM customers WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    $sql = "DELETE FROM customers WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing Customer',  $result['fullname'].' was removed');
    header('Location: ../customer.php?type=success&message='.$result['fullname'].' was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing Staff', $th);
    header('Location: ../customer.php?type=error&message=Something went wrong, please try again');
}