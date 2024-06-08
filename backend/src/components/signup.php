<?php
// Database connection
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into database
    $query = "INSERT INTO users (username, fullname, dob, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssss', $username, $fullname, $dob, $email, $phone, $password);
    if ($stmt->execute()) {
        echo "Sign Up Successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
