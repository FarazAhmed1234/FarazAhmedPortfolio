<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT name, institution, description, skills, credentialId, dateOfIssue, verifyLink, picture FROM certifications";
$result = $conn->query($sql);

$certifications = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $certifications[] = $row;
  }
}

echo json_encode($certifications);

$conn->close();
?>
