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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo json_encode(["message" => "Invalid ID"]);
    exit();
}

$sql = "DELETE FROM project_descriptions WHERE id=$id";
if ($conn->query($sql)) {
    echo json_encode(["message" => "Description deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete description"]);
}

$conn->close();
?>
