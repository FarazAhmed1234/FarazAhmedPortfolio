<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Get POST data from FormData
$skill = isset($_POST['skill']) ? trim($_POST['skill']) : '';
$percentage = isset($_POST['percentage']) ? intval($_POST['percentage']) : 0;
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Validation
if (empty($skill) || $percentage <= 0 || $percentage > 100 || $id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

// Update query
$sql = "UPDATE skills SET skill = ?, percentage = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $skill, $percentage, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Skill updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update skill"]);
}

$stmt->close();
$conn->close();
?>
