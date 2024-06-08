<?php
require_once '../../dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE users SET username = ?, fullname = ?, dob = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $username, $fullname, $dob, $email, $phone, $user_id);

    if ($stmt->execute()) {
        echo "User information updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
