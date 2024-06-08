<?php
function sendEmail($to, $subject, $message) {
    $headers = "From: no-reply@spendease.com\r\n";
    $headers .= "Reply-To: no-reply@spendease.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    return mail($to, $subject, $message, $headers);
}
?>
