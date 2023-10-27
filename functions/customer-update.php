<?php
include_once 'connection.php';

try {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sql = "SELECT * FROM customers WHERE fullname = :fullname OR phone = :phone AND id != :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header('Location: ../customer.php?type=error&message='.$fullname.' or '.$phone.' is already exist');
        exit();
    }

    $sql = "UPDATE customers SET fullname = :fullname, address = :address, phone = :phone WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':fullname', $fullname);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':phone', $phone);
    $statement->execute();

    generate_logs('Customer Update', $fullname.'| Info was updated');
    header('Location: ../customer.php?type=success&message=Customer Info was updated successfully!');
    exit();

} catch (\Throwable $th) {
    generate_logs('Customer Update', $fullname.'| Error: '.$th->getMessage());
}

?>