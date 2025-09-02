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

$result = $conn->query("SELECT * FROM social_links");
$links = [];

while ($row = $result->fetch_assoc()) {
  $links[] = $row;
}

echo json_encode($links);
$conn->close();
?>
