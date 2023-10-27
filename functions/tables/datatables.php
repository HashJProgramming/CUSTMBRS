<?php
include_once 'functions/connection.php';
include_once 'functions/data/get-data.php';
include_once 'functions/chart/get-chart.php';
function user_logs(){
    global $db;
    $sql = 'SELECT * FROM logs';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();


    foreach ($results as $row) {
        ?>
             <tr>
                <td>#<?php echo $row['id']; ?></td>
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
                <p class="text-primary card-text mb-0">Cottage #: <?php echo $row['name'].' | '.$row['type']; ?></p>
                <p class="card-text mb-1">Price Day: ₱<?php echo number_format($row['priceDay'], 2); ?></p>
                <p class="card-text mb-1">Price Night: ₱<?php echo number_format($row['priceNight'], 2); ?></p>
                <p class="card-text">Price Package: ₱<?php echo number_format($row['pricePackage'], 2); ?></p>
                <div class="d-flex">
                    <a class="btn btn-primary mx-1" href="calendar.php" type="button">View</a>
                    <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-type="<?php echo $row['type']; ?>" data-day="<?php echo $row['priceDay']; ?>" data-night="<?php echo $row['priceNight']; ?>" data-package="<?php echo $row['pricePackage']; ?>" data-bs-toggle="modal">Update</button>
                    <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove"data-id="<?php echo $row['id']; ?>"  data-bs-toggle="modal">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
}

function cottage_available_list($start, $end, $type){
    global $db;
    $sql = 'SELECT * FROM cottages WHERE `type` = :type';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $cottages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cottages as $cottage) {
        $sql = "SELECT * FROM rentals, cottages 
                WHERE `cottage_id` = :cottage_id 
                AND (:start_datetime BETWEEN `start_datetime` AND `end_datetime`
                    OR :end_datetime BETWEEN `start_datetime` AND `end_datetime`
                    OR `start_datetime` BETWEEN :start_datetime AND :end_datetime)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':cottage_id', $cottage['id']);
        $stmt->bindParam(':start_datetime', $start);
        $stmt->bindParam(':end_datetime', $end);
        $stmt->execute();
        $rental = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rental) {
            ?>
            <div class="col-xl-4">
                <div class="card">
                    <img class="card-img-top w-100 d-block fit-cover" style="height: 200px;" src="functions/<?php echo $cottage['picture']; ?>">
                    <div class="card-body p-4">
                        <p class="text-primary card-text mb-0">Cottage ID: <?php echo $cottage['id']; ?> | <?php echo $cottage['type']; ?></p>
                        <p class="card-text mb-1">Price Day: ₱<?php echo number_format($cottage['priceDay'], 2); ?></p>
                        <p class="card-text mb-1">Price Night: ₱<?php echo number_format($cottage['priceNight'], 2); ?></p>
                        <p>Price Package: ₱<?php echo number_format($cottage['pricePackage'], 2); ?></p>
                        <div class="container mb-4">
                            <div class="row">
                                <div class="col">
                                    <form action="" method="post">
                                    <button class="btn btn-primary w-100" href="#add" type="button" data-bs-target="#add" data-bs-toggle="modal"
                                    data-id="<?php echo $cottage['id']; ?>"
                                    data-type="<?php echo $cottage['type']; ?>"
                                    data-start="<?php echo $_GET['start']; ?>"
                                    data-end="<?php echo $_GET['end']; ?>"
                                    >Add Cottage</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
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
                <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png">#<?php echo $row['cottage_name']; ?></td>
                <td><?php echo $row['start_datetime']; ?></td>
                <td><?php echo $row['end_datetime']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td class="text-center">
                    <a class="mx-1" href="#" data-bs-target="#update" data-id="<?php echo $row['id']?>" data-type="<?php echo $row['type']?>" data-start="<?php echo $row['start_datetime']?>" data-end="<?php echo $row['end_datetime']?>" data-bs-toggle="modal"><i class="fas fa-user-edit fs-4 text-warning"></i></a>
                    <a class="mx-1" href="#" data-bs-target="#remove" data-id="<?php echo $row['id']?>" data-bs-toggle="modal"><i class="fas fa-trash-alt fs-4 text-danger"></i></a>
                </td>
            </tr>
            <?php
        }
    }
}


function get_top_customers(){
    global $db;
    $sql = "SELECT c.fullname, COUNT(*) AS total FROM transactions t
        JOIN customers c ON t.customer_id = c.id
        WHERE t.status = 'Proceed'
        GROUP BY c.fullname
        ORDER BY total DESC
        LIMIT 3";
    $statement = $db->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll();

    foreach ($results as $row) {
        ?>
        <li class="list-group-item">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <h6 class="mb-0"><strong><?php echo $row['fullname']?></strong></h6>
                    <span class="text-xs">RENT COUNT : <?php echo $row['total']?></span>
                </div>
                <div class="col-auto"><i class="fas fa-star"></i></div>
            </div>
        </li>
        <?php
    }
}


function get_top_cottages(){
    global $db;
    $sql = "SELECT c.name, COUNT(*) AS total FROM transactions t
        JOIN cottages c ON t.customer_id = c.id
        WHERE t.status = 'Proceed'
        GROUP BY c.name
        ORDER BY total DESC
        LIMIT 3";
    $statement = $db->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll();

    foreach ($results as $row) {
        ?>
        <li class="list-group-item">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <h6 class="mb-0"><strong><?php echo $row['name']?></strong></h6>
                    <i class="far fa-credit-card"></i>
                    <span class="text-xs">RENT COUNT: <?php echo $row['total']?></span>
                </div>
                <div class="col-auto"><i class="fas fa-star"></i></div>
            </div>
        </li>
        <?php
    }
}


function activity_logs(){
    global $db;
    $sql = 'SELECT * FROM logs';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
             <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo $row['logs'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
            </tr>
    <?php
    }
}

function sales_report(){
    global $db;
    $sql = "SELECT r.id AS rental_id,
            r.type AS rental_type,
            c.name AS cottage_name,
            r.created_at AS created_at,
            r.start_datetime AS startdate,
            r.end_datetime AS enddate,
            t.payment_status AS payment_status,
            CASE
                WHEN r.type = 'day' THEN c.priceDay
                WHEN r.type = 'night' THEN c.priceNight
                WHEN r.type = 'package' THEN c.pricePackage
                ELSE 0
            END AS cottage_price
        FROM rentals r
        JOIN cottages c ON r.cottage_id = c.id
        JOIN `transactions` t ON r.transact_id = t.id
        WHERE status = 'Proceed';";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        ?>
            <tr>
                <td class="sorting_1"><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png">#<?php echo $row['cottage_name']?></td>
                <td><?php echo $row['cottage_price']?></td>
                <td><?php echo $row['rental_type']?></td>
                <td><?php echo $row['startdate']?></td>
                <td><?php echo $row['enddate']?></td>
                <td><?php echo $row['payment_status']?></td>
                <td><?php echo $row['created_at']?></td>
            </tr>
    <?php
    }
}


function rentals_list(){
    global $db;
    $sql = "SELECT r.id AS rental_id,
            r.type AS rental_type,
            c.name AS cottage_name,
            r.start_datetime AS startdate,
            r.end_datetime AS enddate,
            r.created_at AS created_at,
            r.amount AS amount,
            t.payment_status AS payment_status,
            t.id AS transaction_id,
            u.fullname AS customer_name,
            CASE
                WHEN r.type = 'day' THEN c.priceDay
                WHEN r.type = 'night' THEN c.priceNight
                WHEN r.type = 'package' THEN c.pricePackage
                ELSE 0
            END AS cottage_price
        FROM rentals r
        JOIN cottages c ON r.cottage_id = c.id
        JOIN `transactions` t ON r.transact_id = t.id
        JOIN `customers` u ON t.customer_id = u.id
        WHERE t.payment_status = 'UNPAID' OR t.payment_status = 'PARTIALLY PAID';";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $balance = $row['amount'] - $row['cottage_price'];
        ?>
            <tr>
                <td class="sorting_1"><img class="rounded-circle me-2" width="30" height="30" src="assets/img/icon.png">#<?php echo $row['cottage_name']?></td>
                <td>#<?php echo $row['transaction_id']?></td>
                <td><?php echo $row['customer_name']?></td>
                <td><?php echo $row['cottage_price']?></td>
                <td><?php echo $balance?></td>
                <td><?php echo $row['rental_type']?></td>
                <td><?php echo $row['startdate']?></td>
                <td><?php echo $row['enddate']?></td>
                <td><?php echo $row['payment_status']?></td>
                <td><?php echo $row['created_at']?></td>
                <td class="text-center">
                    <button class="btn btn-success mx-1" href="#" data-bs-target="#paid" data-id="<?php echo $row['transaction_id']?>" data-bs-toggle="modal">Mark Paid</button>
                    <?php
                        if ($balance < 0){
                            ?>
                                <button class="btn btn-warning mx-1" href="#" data-bs-target="#partiallypaid" data-id="<?php echo $row['rental_id']?>" data-transaction="<?php echo $row['transaction_id']?>" data-price="<?php echo $row['cottage_price']?>" data-bs-toggle="modal">Mark Partially Paid</button>
                            <?php
                        }
                    ?>
                    <button class="btn btn-danger mx-1" href="#" data-bs-target="#cancel" data-id="<?php echo $row['transaction_id']?>" data-bs-toggle="modal">Cancel</button>
                </td>
            </tr>
    <?php
    }
}