<?php
include_once '../connection.php';
$calendarData = array();

$sql = 'SELECT r.*, co.fullname, c.name AS cottage_name
        FROM rentals AS r
        JOIN cottages AS c ON r.cottage_id = c.id
        JOIN transactions AS t ON r.transact_id = t.id
        JOIN customers AS co ON t.customer_id = co.id';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $event = array(
        'title' => $row['cottage_name'].' | '.$row['fullname'],
        'start' => $row['start_datetime'],
        'end' => $row['end_datetime']
    );
    array_push($calendarData, $event);
}

// Return the calendar data as JSON
header('Content-Type: application/json');
echo json_encode($calendarData);
?>
