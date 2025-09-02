<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection (direct, no config.php)
$host = "localhost";
$user = "root";       // change if your MySQL user is different
$pass = "";           // set password if you have one
$dbname = "portfolio_db"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

$response = array();

// Fetch skills
$sql = "SELECT * FROM skills ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $skills = array();
    while ($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }
    $response['status'] = "success";
    $response['data'] = $skills;
} else {
    $response['status'] = "error";
    $response['message'] = "No skills found.";
}

echo json_encode($response);

$conn->close();
?>
