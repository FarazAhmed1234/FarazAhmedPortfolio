<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "portfolio_db");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB Connection Failed"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $res = $conn->query("SELECT * FROM profile LIMIT 1");
    if ($row = $res->fetch_assoc()) {
        echo json_encode([
            "success" => true,
            "data" => $row
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "No profile found"]);
    }
}
?>
