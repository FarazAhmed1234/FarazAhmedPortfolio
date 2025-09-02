<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "portfolio_db");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT id, name, category_name, description, tech_stack, github_url, live_url, image FROM projects";
$result = $conn->query($sql);

$projects = [];
$base_url = "http://localhost:8080/backend-portfolio/uploads/";  // your image folder

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['tech_stack'] = explode(",", $row['tech_stack']); // convert comma string → array

        // prepend full image URL if image exists
        if (!empty($row['image'])) {
            $row['image'] = $base_url . $row['image'];
        }

        $projects[] = $row;
    }
}

echo json_encode($projects);

$conn->close();
?>
