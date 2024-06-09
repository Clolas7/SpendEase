<?php
require_once '../../dbconfig.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("error" => "User not authenticated"));
    exit();
}

$user_id = $_SESSION['user_id'];

// Préparer et exécuter la requête pour récupérer les notifications
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY date_sent DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $notifications = array();

    // Parcourir les résultats et ajouter chaque notification au tableau
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Retourner les notifications en format JSON
    echo json_encode(array("notifications" => $notifications));
} else {
    // En cas d'erreur dans l'exécution de la requête, retourner un message d'erreur
    echo json_encode(array("error" => "Failed to fetch notifications"));
}

$stmt->close();
$conn->close();
?>
