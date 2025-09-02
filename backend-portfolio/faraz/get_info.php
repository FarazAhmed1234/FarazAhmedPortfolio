<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$host = "localhost";
$user = "root";   // your DB user
$pass = "";       // your DB password
$dbname = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit();
}

$sql = "SELECT label, value FROM info";
$result = $conn->query($sql);

$info = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $info[$row['label']] = $row['value'];
    }
}

echo json_encode(["success" => true, "data" => $info]);

$conn->close();
?>
