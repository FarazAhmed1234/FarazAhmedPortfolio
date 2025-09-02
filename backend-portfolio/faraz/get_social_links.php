<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// DB connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit();
}

$sql = "SELECT platform, url FROM social_links";
$result = $conn->query($sql);

$socials = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $socials[$row["platform"]] = $row["url"]; 
        // Example: $socials["LinkedIn"] = "https://linkedin.com/in/...";
    }
}

echo json_encode(["success" => true, "data" => $socials]);
$conn->close();
?>
