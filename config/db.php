<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'appzpuzd_invoice');
define('DB_USER', 'appzpuzd_invoice');         // Change in production
define('DB_PASS', 'aA115599!!');             // Change in production
define('DB_CHARSET', 'utf8mb4');

// Connect to database using PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // In production, log the error instead of displaying it
    die('Database connection failed: ' . $e->getMessage());
}