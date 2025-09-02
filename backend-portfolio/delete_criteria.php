<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['id'])) {
    echo json_encode(["status" => false, "message" => "Invalid request."]);
    exit;
}

$id = intval($_GET['id']);

$conn = new mysqli("localhost", "root", "", "portfolio_db");
if ($conn->connect_error) {
    die(json_encode(["status" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$stmt = $conn->prepare("DELETE FROM criteria WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => true, "message" => "Category deleted successfully."]);
} else {
    echo json_encode(["status" => false, "message" => "Error deleting Category."]);
}

$stmt->close();
$conn->close();
?>
