<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY date_sent DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = array();
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
?>
