<?php
include_once '../config/database.php';

// Action: add, update, delete
$action = $_POST['action'];
$user_id = $_POST['user_id'];
$amount = $_POST['amount'];
$goal = $_POST['goal'];
$date = $_POST['date'];

switch ($action) {
    case 'add':
        $stmt = $conn->prepare("INSERT INTO savings (user_id, amount, goal, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $user_id, $amount, $goal, $date);
        $stmt->execute();
        echo "Saving added successfully.";
        break;
    case 'update':
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE savings SET user_id = ?, amount = ?, goal = ?, date = ? WHERE id = ?");
        $stmt->bind_param("idssi", $user_id, $amount, $goal, $date, $id);
        $stmt->execute();
        echo "Saving updated successfully.";
        break;
    case 'delete':
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM savings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "Saving deleted successfully.";
        break;
}
?>
