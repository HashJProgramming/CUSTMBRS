<?php
include_once 'functions/connection.php';

function user_logs(){
    global $db;
    $sql = 'SELECT * FROM logs';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();


    foreach ($results as $row) {
        ?>
             <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo $row['logs'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
            </tr>
    <?php
    }
}

function customer_list(){
    global $db;
    $sql = 'SELECT * FROM customers ORDER BY fullname ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
             <tr>
                <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png"><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
                <td class="text-center">
                    <a data-bss-tooltip="" class="mx-1" href="profile.php?id=<?php echo $row['id']?>" title="Here you can see the customer transactions."><i class="far fa-eye text-primary" style="font-size: 20px;"></i></a>
                    <a data-bs-toggle="modal" data-bss-tooltip="" class="mx-1" href="#" data-bs-target="#update" data-id="<?php echo $row['id']?>" data-fullname="<?php echo $row['fullname']?>" data-address="<?php echo $row['address']?>" data-phone="<?php echo $row['phone']?>" title="Here you can update the customer Information."><i class="far fa-edit text-warning" style="font-size: 20px;"></i></a>
                    <a data-bs-toggle="modal" data-bss-tooltip="" class="mx-1" href="#" data-bs-target="#remove" data-id="<?php echo $row['id']?>" title="Here you can remove the customer."><i class="far fa-trash-alt text-danger" style="font-size: 20px;"></i></a>
                </td>
            </tr>
    <?php
    }
}

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

function staff_list(){
    global $db;
    $sql = 'SELECT * FROM users WHERE `type` = "staff"';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
             <tr>
                <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png"><?php echo $row['username']; ?></td>
                <td><?php echo $row['password'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
                <td class="text-center">
                    <a data-bs-toggle="modal" data-bss-tooltip="" class="mx-1" href="#" data-bs-target="#update" data-id="<?php echo $row['id']?>" data-username="<?php echo $row['username']?>" data-address="<?php echo $row['address']?>" data-phone="<?php echo $row['phone']?>" title="Here you can update the customer Information."><i class="far fa-edit text-warning" style="font-size: 20px;"></i></a>
                    <a data-bs-toggle="modal" data-bss-tooltip="" class="mx-1" href="#" data-bs-target="#remove" data-id="<?php echo $row['id']?>" title="Here you can remove the customer."><i class="far fa-trash-alt text-danger" style="font-size: 20px;"></i></a>
                </td>
            </tr>
    <?php
    }
}