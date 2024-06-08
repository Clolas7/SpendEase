<?php
require_once '../../dbconfig.php';

session_start();
$user_id = $_SESSION['user_id'];

$start_date = $_GET['start_date'] ?? '1900-01-01';
$end_date = $_GET['end_date'] ?? '2100-01-01';

// Fetch expenses data
$expenses_query = "SELECT category_id, SUM(amount) as total_amount FROM expenses WHERE user_id = ? AND date BETWEEN ? AND ? GROUP BY category_id";
$expenses_stmt = $conn->prepare($expenses_query);
$expenses_stmt->bind_param("iss", $user_id, $start_date, $end_date);
$expenses_stmt->execute();
$expenses_result = $expenses_stmt->get_result();

$expenses_data = array();
while ($row = $expenses_result->fetch_assoc()) {
    $expenses_data[] = $row;
}

// Fetch incomes data
$incomes_query = "SELECT source, SUM(amount) as total_amount FROM incomes WHERE user_id = ? AND date BETWEEN ? AND ? GROUP BY source";
$incomes_stmt = $conn->prepare($incomes_query);
$incomes_stmt->bind_param("iss", $user_id, $start_date, $end_date);
$incomes_stmt->execute();
$incomes_result = $incomes_stmt->get_result();

$incomes_data = array();
while ($row = $incomes_result->fetch_assoc()) {
    $incomes_data[] = $row;
}

// Generate CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Type', 'Category/Source', 'Amount'));

foreach ($expenses_data as $expense) {
    fputcsv($output, array('Expense', 'Category ' . $expense['category_id'], $expense['total_amount']));
}

foreach ($incomes_data as $income) {
    fputcsv($output, array('Income', $income['source'], $income['total_amount']));
}

fclose($output);
?>
