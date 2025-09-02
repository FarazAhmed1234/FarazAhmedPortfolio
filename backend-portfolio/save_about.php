<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$host = "localhost";
$user = "root";  
$pass = "";      
$db   = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $details = $_POST['details'] ?? '';
    $story   = $_POST['story'] ?? '';

    if (isset($_FILES['cv'])) {
        $cvName = time() . "_" . basename($_FILES['cv']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $cvName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['cv']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO about_details (details, story, cv) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $details, $story, $cvName);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "DB Insert failed"]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "CV file missing"]);
    }
}

$conn->close();
