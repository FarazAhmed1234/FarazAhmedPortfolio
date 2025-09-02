<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// ---- Database connection ----
$host = "localhost";
$user = "root";        // your DB username
$pass = "";            // your DB password
$db   = "portfolio_db";   // your DB name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// ---- Fetch all descriptions ----
$sql = "SELECT id, description FROM project_descriptions ORDER BY id DESC";
$result = $conn->query($sql);

$descriptions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $descriptions[] = [
            "id" => $row["id"],
            "description" => $row["description"]
        ];
    }
}

// Return JSON
echo json_encode($descriptions);

$conn->close();
?>
