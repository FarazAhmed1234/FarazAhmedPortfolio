<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");



// Database connection
$servername = "localhost";
$username   = "root";     // your MySQL username
$password   = "";         // your MySQL password
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all info
$sql = "SELECT * FROM info ORDER BY id DESC";
$result = $conn->query($sql);

$infos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $infos[] = $row;
    }
}

echo json_encode($infos);

$conn->close();
?>
