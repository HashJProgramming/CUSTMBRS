<?php
include_once 'connection.php';
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
try {
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM transactions WHERE user_id = :user_id AND status = 'Pending'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$transaction) {
        header('Location: ../rent.php?type=error&message=You have a pending transaction');
        exit();
    }
    
    $sql = "DELETE FROM transactions WHERE user_id = :user_id AND status = 'Pending'";
    $statement = $db->prepare($sql);
    $statement->bindParam(':user_id', $user_id); 
    $statement->execute(); 
    generate_logs('Cancel Transaction','Transaction was cancel');
    header('Location: ../rent.php?type=success&message=Transaction was cancel successfully!');

} catch (\Throwable $th) {
    echo $th;
    generate_logs('Cancel Transaction', $th);
    header('Location: ../rent.php?type=error&message=Something went wrong, please try again');
}