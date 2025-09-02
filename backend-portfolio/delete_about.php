<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Direct DB connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Read JSON request
$data = json_decode(file_get_contents("php://input"), true);

$id   = isset($data['id']) ? intval($data['id']) : 0;
$type = isset($data['type']) ? $data['type'] : "";

if (!$id || !$type) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

if ($type === "all") {
    // Delete the entire record
    $sql = "DELETE FROM about_details WHERE id = $id";

} elseif ($type === "details") {
    // Clear only details
    $sql = "UPDATE about_details SET details='' WHERE id = $id";

} elseif ($type === "story") {
    // Clear only story
    $sql = "UPDATE about_details SET story='' WHERE id = $id";

} elseif ($type === "cv") {
    // First remove the physical file if it exists
    $result = $conn->query("SELECT cv FROM about_details WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file = "uploads/" . $row['cv'];
        if (!empty($row['cv']) && file_exists($file)) {
            unlink($file);
        }
    }
    // Clear cv column
    $sql = "UPDATE about_details SET cv='' WHERE id = $id";

} else {
    echo json_encode(["status" => "error", "message" => "Invalid delete type"]);
    exit;
}

// Run query
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
