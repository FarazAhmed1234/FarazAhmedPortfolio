<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'config.php';

// Read raw input
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode([
        'message' => 'No JSON received',
        'raw_input' => $raw   // show what PHP actually got
    ]);
    exit;
}
if (!isset($data['id']) || !isset($data['description']) || empty(trim($data['description']))) {
    http_response_code(400);
    echo json_encode(['message' => 'ID and description are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE service_descriptions SET description = ? WHERE id = ?");
    $stmt->execute([trim($data['description']), $data['id']]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Service description updated successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Service description not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update service description: ' . $e->getMessage()]);
}
?>