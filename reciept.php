<?php
include_once 'functions/authentication.php';
include_once 'functions/connection.php';
$id = $_GET['id'];

$sql = "SELECT SUM(CASE
    WHEN r.type = 'day' THEN co.priceDay
    WHEN r.type = 'night' THEN co.priceNight
    ELSE 0 
END) AS total,
c.fullname 
FROM transactions t
JOIN rentals r ON t.id = r.transact_id
JOIN customers c ON t.customer_id = c.id
JOIN cottages co ON r.cottage_id = co.id
WHERE t.id = :id;";
$statement = $db->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();
$result = $statement->fetch();

$total = $result['total'];
$customer = $result['fullname'];

function getItems(){
    global $id;
    global $db;
    $sql = "SELECT r.*, c.name AS cottage_name,
    CASE
        WHEN r.type = 'day' THEN c.priceDay
        WHEN r.type = 'night' THEN c.priceNight
        ELSE 0 
    END AS price
    FROM rentals AS r
    JOIN cottages AS c ON r.cottage_id = c.id
    WHERE r.transact_id = :transact_id";
    $statement = $db->prepare($sql);
    $statement->bindParam(':transact_id', $id);
    $statement->execute();
    $items = $statement->fetchAll();
    foreach($items as $row){
        $startDateObj = new DateTime($row['start_datetime']);
        $endDateObj = new DateTime($row['end_datetime']);
        $interval = $startDateObj->diff($endDateObj);
        $days = $interval->days;
        ?>
            <tr class="font-monospace" style="font-size: 10px;">
                <td class="font-monospace" style="font-size: 10px;">Cottage:&nbsp;<strong><?php echo $row['cottage_name'] ?></strong></td>
                <td class="font-monospace text-end" style="font-size: 10px;"></td>
                <td class="font-monospace text-center" style="font-size: 10px;"><strong>[<?php echo $row['start_datetime'] ?>] - [<?php echo $row['end_datetime'] ?>] |</strong>&nbsp;<?php echo $days ?> DAYS</td>
                <td class="font-monospace text-end" style="font-size: 10px;"><strong>₱<?php echo number_format($row['price'], 2) ?></strong></td>
            </tr>
        <?php
    }
}


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CUSTMBRS</title>
    <meta name="description" content="CUSTMBRS - Cottage Usage Scheduling with Transaction Monitoring for a Beach Resort System">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/img/icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
</head>

<body onload="printPageAndRedirect()">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="font-monospace text-center" style="color: var(--bs-gray-900);font-size: 13px;">
                    <img src="assets/img/icon.png" width="40">&nbsp;Sere's Point Beach Resort<br>
                    <span style="font-weight: normal !important;">Street Unknown, Pagadian City</span><br>
                    <span style="font-weight: normal !important;">Phone (+63) 000-000-000</span><br>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
                <tr></tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th class="font-monospace text-center" style="font-size: 10px;">Cottage Rental Reciept</th>
                </tr>
            </thead>
            <tbody class="font-monospace">
                <tr class="font-monospace"></tr>
                <tr class="font-monospace"></tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive font-monospace">
        <table class="table table-borderless">
            <thead class="font-monospace">
                <tr class="font-monospace">
                    <th class="font-monospace" style="font-size: 10px;"><span style="font-weight: normal !important;">CUSTOMER: <strong><?php echo $customer; ?></strong></span></th>
                    <th class="font-monospace text-end" style="font-size: 10px;"></th>
                    <th class="font-monospace text-end" style="font-size: 10px;"></th>
                    <th class="font-monospace text-end" style="font-size: 10px;">INVOICE #<?php echo $_GET['id'] ?></th>
                </tr>
            </thead>
            <tbody class="font-monospace">
                <?php getItems() ?>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead class="font-monospace">
                <tr class="font-monospace">
                    <th class="font-monospace text-end"><strong>TOTAL</strong>&nbsp;<strong>₱<?php echo number_format($total, 2); ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap-select.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/three.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/vanta.birds.min.js"></script>
    <script src="assets/js/vanta.waves.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        function printPageAndRedirect() {
            window.print();
            setTimeout(function() {
                window.location.href = 'rent.php';
            }, 1000); // Redirect after 1 second (adjust as needed)
        }
    </script>
</body>

</html>