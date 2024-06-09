<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM expenses WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$report_details = array();
while ($row = $result->fetch_assoc()) {
    $report_details[] = $row;
}

echo json_encode($report_details);
?>
