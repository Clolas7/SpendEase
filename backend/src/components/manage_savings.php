<?php
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Action: add, update, delete
    $action = $_POST['action'];
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $goal = $_POST['goal'];
    $date = $_POST['date'];

    switch ($action) {
        case 'add':
            if ($stmt = $conn->prepare("INSERT INTO savings (user_id, amount, goal, date) VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("idss", $user_id, $amount, $goal, $date);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Saving added successfully.";
                } else {
                    echo "Error adding saving.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            break;
        case 'update':
            $id = $_POST['id'];
            if ($stmt = $conn->prepare("UPDATE savings SET user_id = ?, amount = ?, goal = ?, date = ? WHERE id = ?")) {
                $stmt->bind_param("idssi", $user_id, $amount, $goal, $date, $id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Saving updated successfully.";
                } else {
                    echo "Error updating saving.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            break;
        case 'delete':
            $id = $_POST['id'];
            if ($stmt = $conn->prepare("DELETE FROM savings WHERE id = ?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "Saving deleted successfully.";
                } else {
                    echo "Error deleting saving.";
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
