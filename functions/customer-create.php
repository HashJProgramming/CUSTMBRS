<?php
include_once 'connection.php';

$fullname = $_POST['fullname'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$sql = "SELECT * FROM customers WHERE fullname = :fullname OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../customer.php?type=error&message='.$fullname.' or '.$phone.' is already exist');
    exit();
}

$sql = "INSERT INTO customers (fullname, address, phone) VALUES (:fullname, :address, :phone)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

generate_logs('Adding Customer', $fullname.'| New Customer was added');
header('Location: ../customer.php?type=success&message=New customer was added successfully');
?>