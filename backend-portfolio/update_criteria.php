<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['name'])) {
    echo json_encode(["status" => false, "message" => "Invalid data."]);
    exit;
}

$id = intval($data['id']);
$name = trim($data['name']);

$conn = new mysqli("localhost", "root", "", "portfolio_db");
if ($conn->connect_error) {
    die(json_encode(["status" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$stmt = $conn->prepare("UPDATE criteria SET name=? WHERE id=?");
$stmt->bind_param("si", $name, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => true, "message" => "Category updated successfully."]);
} else {
    echo json_encode(["status" => false, "message" => "Error updating Category."]);
}

$stmt->close();
$conn->close();
?>
