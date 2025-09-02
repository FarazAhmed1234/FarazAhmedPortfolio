<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$host = "localhost";
$user = "root";   // your DB user
$pass = "";       // your DB password
$dbname = "portfolio_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// fetch latest CV from about_details
$sql = "SELECT cv_file FROM about_details ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = $row['cv_file'];

    // Serve file download
    if (file_exists($filePath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="FarazAhmedCV.pdf"');
        readfile($filePath);
        exit;
    } else {
        echo "CV file not found.";
    }
} else {
    echo "No CV found in database.";
}

$conn->close();
?>
