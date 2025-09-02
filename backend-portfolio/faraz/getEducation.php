<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Database connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Query education data
$sql = "SELECT name, institution, start_year, end_year FROM education ORDER BY start_year DESC";
$result = $conn->query($sql);

$education = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $education[] = $row;
    }
}

echo json_encode($education);
$conn->close();
?>
