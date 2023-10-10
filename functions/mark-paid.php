<?php
include_once 'connection.php';

$id = $_POST['id'];
$sql = "UPDATE `transactions` SET `payment_status` = 'PAID' WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();

generate_logs('Mark Paid', 'Transaction ID:'.$id.'| Transaction has been marked as Paid');
header('Location: ../rentals.php?type=success&message=Transaction has been marked as paid.');