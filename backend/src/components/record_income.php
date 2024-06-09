<?php
require_once '../../dbconfig.php';
require_once 'send_email.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assumes the user is logged in and user_id is stored in session
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $source = $_POST['source'];

    try {
        $query = "INSERT INTO incomes (user_id, amount, date, source) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }
        $stmt->bind_param('iiss', $user_id, $amount, $date, $source);

        if ($stmt->execute()) {
            // Fetch user email
            $user_query = "SELECT email FROM users WHERE id = ?";
            $user_stmt = $conn->prepare($user_query);
            if (!$user_stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }
            $user_stmt->bind_param('i', $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user = $user_result->fetch_assoc();

            $to = $user['email'];
            $subject = "New Income Recorded";
            $message = "A new income of $amount has been recorded on $date.";

            sendEmail($to, $subject, $message);

            echo json_encode(["status" => "success", "message" => "Income recorded and notification sent successfully!"]);
        } else {
            throw new Exception("Failed to execute statement: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
