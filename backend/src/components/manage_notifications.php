<?php
include_once '../config/database.php';

$action = $_POST['action'];
$user_id = $_POST['user_id'];
$type = $_POST['type'];
$message = $_POST['message'];
$date_sent = date("Y-m-d H:i:s");

try {
    switch ($action) {
        case 'add':
            $stmt = $conn->prepare("INSERT INTO notifications (user_id, type, message, date_sent) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $type, $message, $date_sent);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Notification ajoutée avec succès."]);
            } else {
                throw new Exception("Erreur lors de l'ajout de la notification.");
            }
            break;
        case 'mark_read':
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Notification marquée comme lue."]);
            } else {
                throw new Exception("Erreur lors de la mise à jour de la notification.");
            }
            break;
        case 'delete':
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Notification supprimée avec succès."]);
            } else {
                throw new Exception("Erreur lors de la suppression de la notification.");
            }
            break;
        default:
            throw new Exception("Action non reconnue.");
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
