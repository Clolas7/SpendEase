<?php
$servername = "localhost";
$username = "id22286143_chris";
$password = "7Clolas96@";
$dbname = "spendease";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
