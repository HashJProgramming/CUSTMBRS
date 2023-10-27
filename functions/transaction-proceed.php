<?php
include_once 'connection.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM transactions WHERE `user_id` = :user_id AND `status` = 'Pending'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $id = $transaction['id'];
    $sql = "SELECT COUNT(r.id) AS total, c.fullname 
    FROM transactions t
    JOIN rentals r ON t.id = r.transact_id
    JOIN customers c ON t.customer_id = c.id
    WHERE t.id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch();
   
if($result['total'] == 0){
    header("Location: ../rent.php?type=error&message=Please add cottage to rent first.");
    exit();
}

$sql = "UPDATE `transactions` SET `status` = 'Proceed', `payment_status` = 'UNPAID' WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();

header("Location: ../reciept.php?id=$id");