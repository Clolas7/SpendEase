<?php
include_once '../config/database.php';

// Action: add, update, delete
$action = $_POST['action'];
$user_id = $_POST['user_id'];
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

switch ($action) {
    case 'add':
        $stmt = $conn->prepare("INSERT INTO budgets (user_id, category_id, amount, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidss", $user_id, $category_id, $amount, $start_date, $end_date);
        $stmt->execute();
        echo "Budget added successfully.";
        break;
    case 'update':
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE budgets SET user_id = ?, category_id = ?, amount = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("iidssi", $user_id, $category_id, $amount, $start_date, $end_date, $id);
        $stmt->execute();
        echo "Budget updated successfully.";
        break;
    case 'delete':
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM budgets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "Budget deleted successfully.";
        break;
}
?>
