<?php
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Action: add, update, delete
    $action = $_POST['action'];
    $user_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    switch ($action) {
        case 'add':
            if ($stmt = $conn->prepare("INSERT INTO budgets (user_id, category_id, amount, start_date, end_date) VALUES (?, ?, ?, ?, ?)")) {
                $stmt->bind_param("iidss", $user_id, $category_id, $amount, $start_date, $end_date);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Budget added successfully.";
                } else {
                    echo "Error adding budget.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            break;
        case 'update':
            $id = $_POST['id'];
            if ($stmt = $conn->prepare("UPDATE budgets SET user_id = ?, category_id = ?, amount = ?, start_date = ?, end_date = ? WHERE id = ?")) {
                $stmt->bind_param("iidssi", $user_id, $category_id, $amount, $start_date, $end_date, $id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Budget updated successfully.";
                } else {
                    echo "Error updating budget.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            break;
        case 'delete':
            $id = $_POST['id'];
            if ($stmt = $conn->prepare("DELETE FROM budgets WHERE id = ?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Budget deleted successfully.";
                } else {
                    echo "Error deleting budget.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            break;
        default:
            echo "Invalid action.";
            break;
    }
} else {
    echo "Invalid request method.";
}
?>
