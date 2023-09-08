<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    
    $sql = "SELECT * FROM cottages WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    $sql = "DELETE FROM cottages WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing cottage',  $result['name'].' was removed');
    header('Location: ../cottage.php?type=success&message='.$result['name'].' was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing cottages', $th);
    header('Location: ../cottage.php?type=error&message=Something went wrong, please try again');
}