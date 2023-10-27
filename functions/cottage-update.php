<?php
include_once 'connection.php';
$id = $_POST['id'];
$name = $_POST['name'];
$type = $_POST['type'];
$day = $_POST['priceDay'];
$night = $_POST['priceNight'];
$package = $_POST['pricePackage'];
$picture = $_FILES['picture'];

$sql = "SELECT * FROM cottages WHERE `name` = :name AND `id` != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../cottage.php?type=error&message=' . $name . ' is already exist');
    exit();
}

$upload_path = '';
if ($picture['error'] === UPLOAD_ERR_OK) {
    $file_extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid() . '.' . $file_extension;
    $upload_dir = 'img/';
    $upload_path = $upload_dir . $new_filename;

    if (!move_uploaded_file($picture['tmp_name'], $upload_path)) {
        header('Location: ../cottage.php?type=error&message=Error uploading the image');
        exit();
    }
}

$sql = "UPDATE cottages SET `name` = :name, `type` = :type, `picture` = :picture, `priceDay` = :priceDay, `priceNight` = :priceNight, `pricePackage` = :pricePackage WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':priceDay', $day);
$stmt->bindParam(':priceNight', $night);
$stmt->bindParam(':pricePackage', $package);
$stmt->bindParam(':picture', $upload_path);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    generate_logs('Adding cottage', $name . '| New cottage was added');
    header('Location: ../cottage.php?type=success&message=New cottage was added successfully');
    exit();
} else {
    header('Location: ../cottage.php?type=error&message=Failed to update the cottage');
    exit();
}