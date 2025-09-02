<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["message" => "Database connection failed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? intval($data['id']) : 0;
$description = isset($data['description']) ? $conn->real_escape_string($data['description']) : '';

if ($id <= 0 || empty($description)) {
    echo json_encode(["message" => "Invalid data"]);
    exit();
}

$sql = "UPDATE project_descriptions SET description='$description' WHERE id=$id";
if ($conn->query($sql)) {
    echo json_encode(["message" => "Description updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update description"]);
}

$conn->close();
?>
