<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    
    $sql = "SELECT * FROM rentals WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    $sql = "DELETE FROM rentals WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    generate_logs('Removing rentals','cottage was removed');
    header('Location: ../rent.php?type=success&message=cottage was removed successfully!');
} catch (\Throwable $th) {
    generate_logs('Removing rentals', $th);
    header('Location: ../rent.php?type=error&message=Something went wrong, please try again');
}