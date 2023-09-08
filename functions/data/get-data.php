<?php

function customers(){
    global $db;
    $sql = 'SELECT * FROM customers ORDER BY fullname ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $select = false;
    foreach ($results as $row) {
        ?>
        <option value="<?php echo $row['id'] ?>" <?php if (!$select) { echo 'selected'; $select = true; } ?>><?php echo $row['fullname'] ?></option>        
    <?php
    }
}

function cotteges(){
    global $db;
    $sql = 'SELECT * FROM `cottages` ORDER BY `name` ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $select = false;
    foreach ($results as $row) {
        ?>
        <option value="<?php echo $row['id'] ?>" <?php if (!$select) { echo 'selected'; $select = true; } ?>><?php echo $row['name'] ?></option>        
    <?php
    }
}

function customer_info($id){
    global $db;
    $sql = 'SELECT * FROM `transactions` WHERE `user_id` = :id AND `status` = "Pending"';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $sql = 'SELECT * FROM `customers` WHERE `id` = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $results[0]['customer_id']);
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results[0] ?? '';
}

