<?php
// Database connection
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM users WHERE username=? OR email=? OR phone=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $identifier, $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "Login Successful!";
            // Set session variables, etc.
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
