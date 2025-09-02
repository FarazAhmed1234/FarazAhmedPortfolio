<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT details, story, cv FROM about_details LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // If CV is stored as filename only, prepend full path
    if (!empty($row['cv'])) {
        $row['cv'] = "http://localhost:8080/backend-portfolio/uploads/" . $row['cv'];
    }

    echo json_encode($row, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["details" => "", "story" => "", "cv" => ""]);
}

$conn->close();
?>
