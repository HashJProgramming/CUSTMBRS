<?php
include_once 'connection.php';

$id = $_POST['id'];
$sql = "DELETE FROM `transactions` WHERE id = :id";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();

generate_logs('Cancel Transaction', 'Transaction ID:'.$id.'| Transaction has been cancelled');
header('Location: ../rentals.php?type=success&message=Transaction has been cancelled.');