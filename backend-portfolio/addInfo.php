<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");



$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$label = $conn->real_escape_string($data["label"]);
$value = $conn->real_escape_string($data["value"]);

// If label exists → update, else insert
$sqlCheck = "SELECT id FROM info WHERE label = '$label'";
$result   = $conn->query($sqlCheck);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id  = $row["id"];
    $sql = "UPDATE info SET value = '$value' WHERE id = $id";
} else {
    $sql = "INSERT INTO info (label, value) VALUES ('$label', '$value')";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
?>
