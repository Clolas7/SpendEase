<?php
require_once '../../dbconfig.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("error" => "User not authenticated"));
    exit();
}

$user_id = $_SESSION['user_id'];
$month = $_POST['month'];
$year = $_POST['year'];

try {
    // Préparer et exécuter la requête pour récupérer les dépenses
    $sql = "SELECT * FROM expenses WHERE user_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("iii", $user_id, $month, $year);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $expenses = array();

    // Parcourir les résultats et ajouter chaque dépense au tableau
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    // Retourner les dépenses en format JSON
    echo json_encode(array("expenses" => $expenses));
} catch (Exception $e) {
    // En cas d'erreur, retourner un message d'erreur
    echo json_encode(array("error" => $e->getMessage()));
}

$stmt->close();
$conn->close();
?>
