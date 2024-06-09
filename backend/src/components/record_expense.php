<?php
require_once '../../dbconfig.php';
require_once 'send_email.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assumes the user is logged in and user_id is stored in session
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    try {
        $query = "INSERT INTO expenses (user_id, category_id, amount, date, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }
        $stmt->bind_param('iisss', $user_id, $category_id, $amount, $date, $description);

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
            $subject = "New Expense Recorded";
            $message = "A new expense of $amount has been recorded on $date.";

            sendEmail($to, $subject, $message);

            echo json_encode(["status" => "success", "message" => "Expense recorded and notification sent successfully!"]);
        } else {
            throw new Exception("Failed to execute statement: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
