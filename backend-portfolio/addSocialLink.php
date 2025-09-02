<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";   // change if needed
$pass = "";       // change if needed
$db   = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "DB connection failed"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$platform = $data["platform"] ?? "";
$url = $data["url"] ?? "";

if ($platform && $url) {
  $stmt = $conn->prepare("INSERT INTO social_links (platform, url) VALUES (?, ?)");
  $stmt->bind_param("ss", $platform, $url);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Link added successfully"]);
  } else {
    echo json_encode(["success" => false, "message" => "Insert failed"]);
  }
  $stmt->close();
} else {
  echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
?>
