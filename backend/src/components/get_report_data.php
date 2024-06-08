<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

// Fetch expenses data
$expenses_query = "SELECT category_id, SUM(amount) as total_amount FROM expenses WHERE user_id = ? GROUP BY category_id";
$expenses_stmt = $conn->prepare($expenses_query);
$expenses_stmt->bind_param("i", $user_id);
$expenses_stmt->execute();
$expenses_result = $expenses_stmt->get_result();

$expenses_data = array();
while ($row = $expenses_result->fetch_assoc()) {
    $expenses_data[] = $row;
}

// Fetch incomes data
$incomes_query = "SELECT source, SUM(amount) as total_amount FROM incomes WHERE user_id = ? GROUP BY source";
$incomes_stmt = $conn->prepare($incomes_query);
$incomes_stmt->bind_param("i", $user_id);
$incomes_stmt->execute();
$incomes_result = $incomes_stmt->get_result();

$incomes_data = array();
while ($row = $incomes_result->fetch_assoc()) {
    $incomes_data[] = $row;
}

echo json_encode(array(
    'expenses' => $expenses_data,
    'incomes' => $incomes_data
));
?>
