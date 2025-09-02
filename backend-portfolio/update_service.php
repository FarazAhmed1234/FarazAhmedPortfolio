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


if (empty($data["id"]) || empty($data["name"]) || empty($data["short_description"]) || empty($data["points"])) {
    echo json_encode(["message" => "Invalid data"]);
    exit;
}

$points = json_decode($data["points"], true);
if (!$points || count($points) !== 4) {
    echo json_encode(["message" => "Exactly 4 points are required"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE services SET name=?, short_description=?, points=? WHERE id=?");
$stmt->execute([$data["name"], $data["short_description"], json_encode($points), $data["id"]]);

echo json_encode(["message" => "Service updated successfully"]);
