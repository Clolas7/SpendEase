<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        // Check if the user exists in the database
        require_once '../../dbconfig.php';
        $phone = $_SESSION['phone'];
        $query = "SELECT * FROM users WHERE phone = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            header('Location: /frontend/src/components/dashboard.html');
        } else {
            header('Location: /frontend/src/components/signup.html?phone=' . $phone);
        }
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
