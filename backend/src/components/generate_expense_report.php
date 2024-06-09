<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

if (!$user_id) {
    echo json_encode(array("error" => "User not authenticated"));
    exit();
}

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$sql = "SELECT expenses.date, categories.name AS category, expenses.amount, expenses.description 
        FROM expenses 
        JOIN categories ON expenses.category_id = categories.id 
        WHERE expenses.user_id = ? AND expenses.date BETWEEN ? AND ?
        ORDER BY expenses.date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$expenses = array();
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

echo json_encode($expenses);

$stmt->close();
$conn->close();
?>
