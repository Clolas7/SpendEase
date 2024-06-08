<?php
require_once '../../dbconfig.php';
session_start();

$user_id = $_SESSION['user_id'];
$query = "SELECT c.name as category, SUM(e.amount) as total FROM expenses e JOIN categories c ON e.category_id = c.id WHERE e.user_id = ? GROUP BY c.name";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$amounts = [];
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['category'];
    $amounts[] = $row['total'];
}

echo json_encode(['labels' => $labels, 'amounts' => $amounts]);
?>
