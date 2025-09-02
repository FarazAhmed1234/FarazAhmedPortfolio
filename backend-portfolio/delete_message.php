<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// ✅ Get ID (works for DELETE too)
$id = null;
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse query string manually
    parse_str($_SERVER['QUERY_STRING'], $query);
    if (isset($query['id'])) {
        $id = intval($query['id']);
    }
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

if ($id) {
    $sql = "DELETE FROM messages WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No ID provided"]);
}

$conn->close();
?>
