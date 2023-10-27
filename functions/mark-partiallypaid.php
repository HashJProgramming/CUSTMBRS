<?php
include_once 'connection.php';

$id = $_POST['id'];
$transaction = $_POST['transaction'];
$amount = $_POST['amount'];
$price = $_POST['price'];

$sql = "SELECT * FROM `rentals` WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();
$rental = $statement->fetch();

$amount = $rental['amount'] + $amount;

$sql = "UPDATE `rentals` SET `amount` = :amount WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->bindParam(':amount', $amount);
$statement->execute();

$sql = "UPDATE `transactions` SET `payment_status` = 'PARTIALLY PAID' WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $transaction);
$statement->execute();

generate_logs('Mark Paid', 'Transaction ID:'.$id.'| Transaction has been marked as Partially Paid');
header('Location: ../rentals.php?type=success&message=Transaction has been marked as Partially paid.');