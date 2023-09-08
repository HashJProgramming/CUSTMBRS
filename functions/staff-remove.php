<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    
    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    $sql = "DELETE FROM users WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing user',  $result['username'].' was removed');
    header('Location: ../users.php?type=success&message='.$result['username'].' was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing users', $th);
    header('Location: ../users.php?type=error&message=Something went wrong, please try again');
}