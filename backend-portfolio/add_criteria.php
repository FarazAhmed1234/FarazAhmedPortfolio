<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name']) || empty(trim($data['name']))) {
    echo json_encode(["status" => false, "message" => "Criteria name cannot be empty."]);
    exit;
}

$name = trim($data['name']);

$conn = new mysqli("localhost", "root", "", "portfolio_db");
if ($conn->connect_error) {
    die(json_encode(["status" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$stmt = $conn->prepare("INSERT INTO criteria (name) VALUES (?)");
$stmt->bind_param("s", $name);

if ($stmt->execute()) {
    echo json_encode(["status" => true, "message" => "Category added successfully."]);
} else {
    echo json_encode(["status" => false, "message" => "Error adding Category."]);
}

$stmt->close();
$conn->close();
?>
