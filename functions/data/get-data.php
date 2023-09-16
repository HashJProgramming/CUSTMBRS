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
        <option value="<?php echo $row['id'] ?>" <?php if (!$select) { echo 'selected'; $select = true; } ?>><?php echo $row['name'].' | '.$row['type'] ?></option>        
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

function total_price($id){
    global $db;
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
        WHERE t.user_id = :id AND t.status = 'Pending';";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch();
    return number_format($result['total'], 2);
}

function total_cottage($id){
    global $db;
    $sql = "SELECT COUNT(r.id) AS total,
        c.fullname 
        FROM transactions t
        JOIN rentals r ON t.id = r.transact_id
        JOIN customers c ON t.customer_id = c.id
        JOIN cottages co ON r.cottage_id = co.id
        WHERE t.user_id = :id AND t.status = 'Pending';";
    $statement = $db->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'];
}

function get_sales($period = 'monthly') {
    global $db;
    
    $sql = "SELECT SUM(CASE
        WHEN r.type = 'day' THEN co.priceDay
        WHEN r.type = 'night' THEN co.priceNight
        ELSE 0 
        END) AS total
        FROM transactions t
        JOIN rentals r ON t.id = r.transact_id
        JOIN cottages co ON r.cottage_id = co.id
        WHERE t.status = 'Proceed'";
    
    if ($period === 'monthly') {
        $sql .= " AND DATE_FORMAT(t.created_at, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    } elseif ($period === 'annual') {
        $sql .= " AND DATE_FORMAT(t.created_at, '%Y') = DATE_FORMAT(CURRENT_DATE, '%Y')";
    }
    
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    
    return number_format($result['total'], 2);
}

function get_total_customer(){
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM customers";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function new_customer(){
    global $db;
    $sql = "SELECT * FROM customers ORDER BY id DESC LIMIT 1";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['fullname'] ?? 'None';
}

function get_total_cottage(){
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM cottages";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function new_cottage(){
    global $db;
    $sql = "SELECT * FROM cottages ORDER BY id DESC LIMIT 1";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    $name = $result['name'] ?? 'None';
    $type = $result['type'] ?? 'None';
    return $name . ' | ' . $type;
}

function get_total_users(){
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM users";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}

function new_user(){
    global $db;
    $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['username'] ?? 'None';
}

function get_top_customer(){
    global $db;
    $sql = "SELECT c.fullname, COUNT(*) AS total FROM transactions t
        JOIN customers c ON t.customer_id = c.id
        WHERE t.status = 'Proceed'
        GROUP BY c.fullname
        ORDER BY total DESC
        LIMIT 1";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['fullname'] ?? 'None';
}

function get_top_cottage(){
    global $db;
    $sql = "SELECT c.name, COUNT(*) AS total FROM rentals r
        JOIN cottages c ON r.cottage_id = c.id
        GROUP BY c.name
        ORDER BY total DESC
        LIMIT 1";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['name'] ?? 'None';
}

function get_current_sales(){
    global $db;
    $sql = "SELECT SUM(CASE
        WHEN r.type = 'day' THEN co.priceDay
        WHEN r.type = 'night' THEN co.priceNight
        ELSE 0 
        END) AS total
        FROM transactions t
        JOIN rentals r ON t.id = r.transact_id
        JOIN cottages co ON r.cottage_id = co.id
        WHERE t.status = 'Proceed'
        AND DATE_FORMAT(t.created_at, '%Y-%m-%d') = DATE_FORMAT(CURRENT_DATE, '%Y-%m-%d')";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return number_format($result['total'], 2);
}

function get_total_user_logs(){
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM logs";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();
    return $result['total'] ?? 0;
}