<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";   // change if needed
$pass = "";
$dbname = "portfolio_db";

// connect
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$skill = $_POST['skill'] ?? '';
$percentage = $_POST['percentage'] ?? '';

if ($skill && $percentage) {
    // ✅ Check if skill already exists
    $checkSql = "SELECT id FROM skills WHERE skill = '$skill'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This skill already exists"]);
    } else {
        $sql = "INSERT INTO skills (skill, percentage) VALUES ('$skill', '$percentage')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Skill saved successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
}

$conn->close();
?>
