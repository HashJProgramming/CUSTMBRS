<?php
include_once 'connection.php';

$name = $_POST['name'];
$type = $_POST['type'];
$day = $_POST['priceDay'];
$night = $_POST['priceNight'];
$package = $_POST['pricePackage'];
$picture = $_FILES['picture'];

$sql = "SELECT * FROM cottages WHERE `name` = :name";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../cottage.php?type=error&message=' . $name . ' is already exist');
    exit();
}

if ($picture['error'] === UPLOAD_ERR_OK) {
    $file_extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid() . '.' . $file_extension;
    $upload_dir = 'img/';
    $upload_path = $upload_dir . $new_filename;

    if (move_uploaded_file($picture['tmp_name'], $upload_path)) {
        $sql = "INSERT INTO cottages (`name`, `type`, `picture`, `priceDay`, `priceNight`, `pricePackage`) VALUES (:name, :type, :picture, :priceDay, :priceNight, :pricePackage)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':priceDay', $day);
        $stmt->bindParam(':priceNight', $night);
        $stmt->bindParam(':pricePackage', $package);
        $stmt->bindParam(':picture', $upload_path);
        $stmt->execute();

        generate_logs('Adding cottage', $name . '| New cottage was added');
        header('Location: ../cottage.php?type=success&message=New cottage was added successfully');
        exit();
    } else {
        header('Location: ../cottage.php?type=error&message=Error uploading the image');
        exit();
    }
} else {
    header('Location: ../cottage.php?type=error&message=Image upload failed');
    exit();
}
?>
