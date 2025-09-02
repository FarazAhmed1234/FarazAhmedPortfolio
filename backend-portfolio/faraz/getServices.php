<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = "localhost";
$dbname = "portfolio_db";   // change if needed
$username = "root";         // change if needed
$password = "";             // change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT name, short_description, points FROM services");
    $services = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $features = [];
        if (!empty($row['points'])) {
            $features = json_decode($row['points'], true);
            if (!$features) {
                $features = array_map('trim', explode(",", $row['points']));
            }
        }

        $services[] = [
            "name" => $row['name'],
            "description" => $row['short_description'],
            "features" => $features
        ];
    }

    echo json_encode($services);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
