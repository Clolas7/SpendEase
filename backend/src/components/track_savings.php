<?php
require_once '../../dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $query = "INSERT INTO savings (user_id, amount, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $user_id, $amount, $date);

    if ($stmt->execute()) {
        echo "Savings tracked successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
