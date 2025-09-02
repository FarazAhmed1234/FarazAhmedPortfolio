<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root"; // your db user
$pass = "";     // your db password
$db   = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT skill, percentage FROM skills";
$result = $conn->query($sql);

$skills = [];
while($row = $result->fetch_assoc()) {
  $skills[] = $row;
}

echo json_encode($skills);

$conn->close();
?>
