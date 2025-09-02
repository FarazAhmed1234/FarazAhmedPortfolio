<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");
// DB connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Ensure it's POST with form-data
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

$id      = isset($_POST['id']) ? intval($_POST['id']) : 0;
$details = isset($_POST['details']) ? $conn->real_escape_string($_POST['details']) : "";
$story   = isset($_POST['story']) ? $conn->real_escape_string($_POST['story']) : "";

// If no id, return error
if ($id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid ID"]);
    exit;
}

// Handle CV upload if provided
$cvFileName = "";
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $cvFileName = time() . "_" . basename($_FILES["cv"]["name"]);
    $targetFile = $uploadDir . $cvFileName;

    if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFile)) {
        // Optionally delete old CV file
        $res = $conn->query("SELECT cv FROM about_details WHERE id=$id");
        if ($res && $res->num_rows > 0) {
            $old = $res->fetch_assoc();
            $oldFile = $uploadDir . $old['cv'];
            if (!empty($old['cv']) && file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to upload CV"]);
        exit;
    }
}

// Build SQL
if (!empty($cvFileName)) {
    $sql = "UPDATE about_details SET details='$details', story='$story', cv='$cvFileName' WHERE id=$id";
} else {
    $sql = "UPDATE about_details SET details='$details', story='$story' WHERE id=$id";
}

// Execute query
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
