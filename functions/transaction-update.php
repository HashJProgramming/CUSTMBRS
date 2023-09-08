<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    $sql = "UPDATE rentals SET `type` = :types, `start_datetime` = :start_datetime, `end_datetime` = :end_datetime WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':types', $type);
    $stmt->bindParam(':start_datetime', $start);
    $stmt->bindParam(':end_datetime', $end);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    generate_logs('Updating rentals','rental was updated');
    header('Location: ../rent.php?type=success&message=rental was updated successfully!');
} catch (\Throwable $th) {
    generate_logs('Updating rentals', $th);
    // header('Location: ../rent.php?type=error&message=Something went wrong, please try again');
    echo $th;
}