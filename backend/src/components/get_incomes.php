<?php
require_once '../../dbconfig.php';
session_start();

$user_id = $_SESSION['user_id'];
$query = "SELECT source, SUM(amount) as total FROM incomes WHERE user_id = ? GROUP BY source";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$amounts = [];
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['source'];
    $amounts[] = $row['total'];
}

echo json_encode(['labels' => $labels, 'amounts' => $amounts]);
?>
