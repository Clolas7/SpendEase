<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

$month = $_POST['month'];
$year = $_POST['year'];

$sql = "SELECT * FROM expenses WHERE user_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

$expenses = array();
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

echo json_encode($expenses);
?>
