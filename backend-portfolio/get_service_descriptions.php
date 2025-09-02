<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM service_descriptions ORDER BY id DESC");
    $descriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($descriptions);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch service descriptions: ' . $e->getMessage()]);
}
?>