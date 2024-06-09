<?php
require_once '../../dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $limit = $_POST['limit'];

    $query = "INSERT INTO budgets (user_id, category_id, limit) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE limit = VALUES(limit)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $user_id, $category_id, $limit);

    if ($stmt->execute()) {
        echo "Budget limit set successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
