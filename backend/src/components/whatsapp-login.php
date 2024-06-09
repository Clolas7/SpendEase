<?php
require_once '../../vendor/autoload.php';
require_once '../../dbconfig.php';
session_start();

use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];

    // Twilio credentials
    $sid = 'ACfe18a81ac78bd59984af529cfc3a1242';
    $token = '633d4e241df842f8e8a9ffc8d6f8adcb';
    $twilio = new Client($sid, $token);

    // Generate a random OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['phone'] = $phone;

    // Send OTP via WhatsApp
    $twilio->messages->create(
        "whatsapp:$phone",
        [
            'from' => 'whatsapp:+14155238886',
            'body' => "Your SpendEase OTP is $otp"
        ]
    );

    header('Location: verify_otp.php');
    exit();
}
?>
