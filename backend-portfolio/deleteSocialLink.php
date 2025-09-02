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
  die(json_encode(["error" => "Database connection failed"]));
}
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? 0;

if ($id) {
  $stmt = $conn->prepare("DELETE FROM social_links WHERE id=?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Link deleted"]);
  } else {
    echo json_encode(["success" => false, "message" => "Delete failed"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid ID"]);
}
