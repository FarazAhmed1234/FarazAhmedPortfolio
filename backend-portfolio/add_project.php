<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "portfolio_db");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB Connection failed: " . $conn->connect_error]));
}

$name          = $_POST['name'] ?? '';
$category_name = $_POST['category_name'] ?? ''; // ✅ now we expect category_name
$description   = $_POST['description'] ?? '';
$tech_stack    = $_POST['tech_stack'] ?? '';
$live_url      = $_POST['live_url'] ?? '';
$github_url    = $_POST['github_url'] ?? '';
$imageName     = null;

// ---- Image upload ----
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    $target = "uploads/" . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target);
}

// ---- Insert Query ----
$sql = "INSERT INTO projects (name, category_name, description, tech_stack, live_url, github_url, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $category_name, $description, $tech_stack, $live_url, $github_url, $imageName);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Project added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
