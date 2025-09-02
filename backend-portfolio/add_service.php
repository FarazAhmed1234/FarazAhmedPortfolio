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





if (empty($data["name"]) || empty($data["short_description"]) || empty($data["points"])) {
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

$points = json_decode($data["points"], true);
if (!$points || count($points) !== 4) {
    echo json_encode(["message" => "Exactly 4 points are required"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO services (name, short_description, points) VALUES (?, ?, ?)");
$stmt->execute([$data["name"], $data["short_description"], json_encode($points)]);

echo json_encode(["message" => "Service added successfully"]);
