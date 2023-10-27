<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    $current_timestamp = time();
    $start_timestamp = strtotime($start);
    $end_timestamp = strtotime($end);
    
    $sql = "SELECT * FROM rentals 
        WHERE `cottage_id` = :cottage_id
        AND (:start_datetime BETWEEN `start_datetime` AND `end_datetime`
            OR :end_datetime BETWEEN `start_datetime` AND `end_datetime`
            OR `start_datetime` BETWEEN :start_datetime AND :end_datetime)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cottage_id', $id);
    $stmt->bindParam(':start_datetime', $start);
    $stmt->bindParam(':end_datetime', $end);
    $stmt->execute();
    $rental = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($rental) {
        header('Location: ../rent.php?type=error&message=Cottage is already rented on the selected date');
        exit();
    } 
    if ($start_timestamp < $current_timestamp) {
        header('Location: ../rent.php?type=error&message=Start date must be greater than current date');
        exit();
    }
    if ($end_timestamp < $current_timestamp) {
        header('Location: ../rent.php?type=error&message=End date must be greater than current date');
        exit();
    }

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