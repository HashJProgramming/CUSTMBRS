<?php
    $database = 'custmbrs';
    $db = new PDO('mysql:host=localhost', 'root', '');
    $query = "CREATE DATABASE IF NOT EXISTS $database";

    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec($query);
        $db->exec("USE $database");

        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
              id INT PRIMARY KEY AUTO_INCREMENT,
              username VARCHAR(255),
              password VARCHAR(255),
              phone VARCHAR(255),
              address VARCHAR(255),
              type VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $db->exec("
            CREATE TABLE IF NOT EXISTS customers (
              id INT PRIMARY KEY AUTO_INCREMENT,
              fullname VARCHAR(255),
              address VARCHAR(255),
              phone VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $db->exec("
            CREATE TABLE IF NOT EXISTS cottages (
              id INT PRIMARY KEY AUTO_INCREMENT,
              name VARCHAR(255),
              type VARCHAR(255),
              priceDay DOUBLE,
              priceNight DOUBLE,
              picture VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $db->exec("
            CREATE TABLE IF NOT EXISTS transactions (
              id INT PRIMARY KEY AUTO_INCREMENT,
              customer_id int,
              user_id int,
              status VARCHAR(255),
              created_at DATE DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
              FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");

        $db->exec("
        CREATE TABLE IF NOT EXISTS rentals (
          id INT PRIMARY KEY AUTO_INCREMENT,
          cottage_id INT,
          transact_id INT,
          type VARCHAR(255),
          start_datetime DATETIME,
          end_datetime DATETIME,
          created_at DATE DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (cottage_id) REFERENCES cottages(id) ON DELETE CASCADE,
          FOREIGN KEY (transact_id) REFERENCES transactions(id) ON DELETE CASCADE
        )
    ");

        $db->exec("
          CREATE TABLE IF NOT EXISTS logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            logs TEXT,
            type TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
        ");

        $db->beginTransaction();

        $stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'");
        $stmt->execute();
        $userExists = $stmt->fetchColumn();
        
        if (!$userExists) {
            $stmt = $db->prepare("INSERT INTO `users` (`username`, `password`, `address`, `phone`, `type`) VALUES (:username, :password, 'administrator', '000000000', 'admin')");
            $stmt->bindValue(':username', 'admin');
            $stmt->bindValue(':password', '$2y$10$WgL2d2fzi6IiGiTfXvdBluTLlMroU8zBtIcRut7SzOB6j9i/LbA4K');
            $stmt->execute();
        }
        
        $db->commit();

    } catch(PDOException $e) {
        die("Error creating database: " . $e->getMessage());
    }
    $db = null;
?>