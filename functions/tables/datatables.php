<?php
include_once 'functions/connection.php';
include_once 'functions/data/get-data.php';

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


function cottage_list(){
    global $db;
    $sql = 'SELECT * FROM cottages';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row){
    ?>

    <div class="col-xl-4">
        <div class="card"><img class="card-img-top w-100 d-block fit-cover" style="height: 200px;" src="functions/<?php echo $row['picture']; ?>">
            <div class="card-body p-4">
                <p class="text-primary card-text mb-0">Cottage ID: <?php echo $row['id']; ?></p>
                <h4 class="card-title"><?php echo $row['name']; ?></h4>
                <p class="card-text">Price DayTime: ₱<?php echo number_format($row['priceDay'], 2); ?></p>
                <p class="card-text">Price NightTime: ₱<?php echo number_format($row['priceNight'], 2); ?></p>
                <div class="d-flex">
                    <a class="btn btn-primary mx-1" href="calendar.php" type="button">View</a>
                    <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-day="<?php echo $row['priceDay']; ?>" data-night="<?php echo $row['priceNight']; ?>" data-bs-toggle="modal">Update</button>
                    <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove"data-id="<?php echo $row['id']; ?>"  data-bs-toggle="modal">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
}

function transaction_list(){
    global $db;
    $user_id = $_SESSION['id'];
    
    $sql = "SELECT * FROM transactions WHERE `user_id` = :user_id AND `status` = 'Pending'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($transactions as $transaction) {
        $transaction_id = $transaction['id'];

        $sql = "SELECT r.*, c.name AS cottage_name
                FROM rentals AS r
                JOIN cottages AS c ON r.cottage_id = c.id
                WHERE r.transact_id = :transact_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':transact_id', $transaction_id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            ?>
            <tr>
                <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png">&nbsp;<?php echo $row['cottage_name']; ?></td>
                <td><?php echo $row['start_datetime']; ?></td>
                <td><?php echo $row['end_datetime']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td class="text-center">
                    <a class="mx-1" href="#" data-bs-target="#update" data-id="<?php echo $row['id']?>" data-type="<?php echo $row['type']?>" data-start="<?php echo $row['start_datetime']?>" data-end="<?php echo $row['end_datetime']?>" data-bs-toggle="modal"><i class="fas fa-user-edit fs-4 text-warning"></i></a>
                    <a class="mx-1" href="#" data-bs-target="#remove" data-id="<?php echo $row['id']?>" data-bs-toggle="modal"><i class="fas fa-trash-alt fs-4 text-danger"></i></a>
                </td>
            </tr>
            <?php
        }
    }
}
