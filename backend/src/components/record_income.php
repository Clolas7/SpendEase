<?php
require_once '../../dbconfig.php';
require_once 'send_email.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assumes the user is logged in and user_id is stored in session
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $source = $_POST['source'];

    $query = "INSERT INTO incomes (user_id, amount, date, source) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiss', $user_id, $amount, $date, $source);

    if ($stmt->execute()) {
        // Fetch user email
        $user_query = "SELECT email FROM users WHERE id = ?";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param('i', $user_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user = $user_result->fetch_assoc();

        $to = $user['email'];
        $subject = "New Income Recorded";
        $message = "A new income of $amount has been recorded on $date.";

        sendEmail($to, $subject, $message);

        echo "Income recorded and notification sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
