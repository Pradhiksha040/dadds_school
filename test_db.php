<?php
require_once __DIR__ . '/config/database.php';
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $stmt = $db->query("SELECT COALESCE(SUM(amount), 0) FROM donations WHERE status = 'completed'");
    echo "Total: " . $stmt->fetchColumn() . "\n";
    $stmt = $db->query("SELECT COUNT(*) FROM donations");
    echo "Count: " . $stmt->fetchColumn() . "\n";
} catch (Exception $e) {
    echo $e->getMessage();
}
