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
$platform = $data["platform"] ?? "";
$url = $data["url"] ?? "";

if ($id && $platform && $url) {
  $stmt = $conn->prepare("UPDATE social_links SET platform=?, url=? WHERE id=?");
  $stmt->bind_param("ssi", $platform, $url, $id);
  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Link updated"]);
  } else {
    echo json_encode(["success" => false, "message" => "Update failed"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid input"]);
}
