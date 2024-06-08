<?php
require_once '../../dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Delete user data from related tables first
    $delete_expenses = "DELETE FROM expenses WHERE user_id = ?";
    $delete_incomes = "DELETE FROM incomes WHERE user_id = ?";
    $delete_notifications = "DELETE FROM notifications WHERE user_id = ?";
    $delete_user = "DELETE FROM users WHERE id = ?";

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare($delete_expenses);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $stmt = $conn->prepare($delete_incomes);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $stmt = $conn->prepare($delete_notifications);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $stmt = $conn->prepare($delete_user);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $conn->commit();
        echo "User account deleted successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
