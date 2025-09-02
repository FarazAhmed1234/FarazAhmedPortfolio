<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];

// Handle JSON input
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case "GET":
        $result = $conn->query("SELECT * FROM certifications ORDER BY id DESC");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
        break;

    case "POST":
        $stmt = $conn->prepare("INSERT INTO certifications (name, institution, description, skills, credentialId, dateOfIssue, verifyLink) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $input['name'], $input['institution'], $input['description'], $input['skills'], $input['credentialId'], $input['dateOfIssue'], $input['verifyLink']);
        $stmt->execute();
        echo json_encode(["success" => true]);
        break;

    case "PUT":
        $stmt = $conn->prepare("UPDATE certifications SET name=?, institution=?, description=?, skills=?, credentialId=?, dateOfIssue=?, verifyLink=? WHERE id=?");
        $stmt->bind_param("sssssssi", $input['name'], $input['institution'], $input['description'], $input['skills'], $input['credentialId'], $input['dateOfIssue'], $input['verifyLink'], $input['id']);
        $stmt->execute();
        echo json_encode(["success" => true]);
        break;

    case "DELETE":
        $id = $input['id'];
        $stmt = $conn->prepare("DELETE FROM certifications WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(["success" => true]);
        break;

    default:
        echo json_encode(["error" => "Invalid Method"]);
}
$conn->close();
?>
