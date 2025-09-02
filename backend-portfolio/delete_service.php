<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'config.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'ID is required']);
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Service deleted successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Service not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to delete service: ' . $e->getMessage()]);
}
?>