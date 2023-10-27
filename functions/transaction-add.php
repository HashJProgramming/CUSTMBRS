<?php
include_once 'connection.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
try {
    $user_id = $_SESSION['id'];
    $cottage_id = $_POST['id'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $type = $_POST['type'];
  
    $current_timestamp = time();
    $start_timestamp = strtotime($start);
    if ($type === 'NIGHT') {
        $end_timestamp = strtotime($start . ' +1 day');
    } else if ($type === 'DAY'){
        $end_timestamp = strtotime($start);
    }else{
        $end_timestamp = strtotime($end);
    }
    $end_date = date('Y-m-d', $end_timestamp);
    $sql = "SELECT * FROM transactions WHERE `user_id` = :user_id AND `status` = 'Pending'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$transaction) {
        header('Location: ../rent.php?type=error&message=Please create a transaction first');
        exit();
    }

    $transaction_id = $transaction['id'];
    $customer_id = $transaction['customer_id'];

    $sql = "SELECT * FROM rentals 
        WHERE `cottage_id` = :cottage_id 
        AND (:start_datetime BETWEEN `start_datetime` AND `end_datetime`
            OR :end_datetime BETWEEN `start_datetime` AND `end_datetime`
            OR `start_datetime` BETWEEN :start_datetime AND :end_datetime)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cottage_id', $cottage_id);
    $stmt->bindParam(':start_datetime', $start);
    $stmt->bindParam(':end_datetime', $end_date);
    $stmt->execute();
    $rental = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rental) {
        header('Location: ../rent.php?type=error&message=Cottage is already rented on the selected date');
        exit();
    }
    if ($end_timestamp < $current_timestamp) {
        header('Location: ../rent.php?type=error&message=End date must be greater than current date');
        exit();
    }

    if (!$transaction) {
        header('Location: ../rent.php?type=error&message=No pending transaction found');
    }

    $sql = "INSERT INTO rentals (`cottage_id`, `transact_id`, `type`, `start_datetime`, `end_datetime`) VALUES (:cottage_id, :transact_id, :types, :start_datetime, :end_datetime)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cottage_id', $cottage_id);
    $stmt->bindParam(':transact_id', $transaction_id);
    $stmt->bindParam(':types', $type);
    $stmt->bindParam(':start_datetime', $start);
    $stmt->bindParam(':end_datetime', $end_date);
    $stmt->execute();

    generate_logs('Add Cottage', $user_id, 'Added new rental');
    header('Location: ../rent.php?type=success&message=New transaction was added successfully');
} catch (\Throwable $th) {
    // generate_logs('Add Cottage', 'Error on adding new rental: ' . $th->getMessage());
    echo $th->getMessage();
}
?>