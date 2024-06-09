<?php
require_once '../../dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $quota_amount = $_POST['quota_amount'];

    $query = "INSERT INTO quotas (user_id, category_id, quota_amount) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quota_amount = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiis', $user_id, $category_id, $quota_amount, $quota_amount);

    if ($stmt->execute()) {
        echo "Quota set successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
