<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['description']) || empty(trim($data['description']))) {
    echo json_encode(["success" => false, "message" => "Description is required"]);
    exit;
}

$description = trim($data['description']);

// Database connection
$servername = "localhost";
$username = "root";      
$password = "";          
$dbname = "portfolio_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO project_descriptions (description) VALUES (?)");
$stmt->bind_param("s", $description);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Project description added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to add description"]);
}

$stmt->close();
$conn->close();
?>
