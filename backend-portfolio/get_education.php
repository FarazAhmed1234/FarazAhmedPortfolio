<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error){ die(json_encode(['status'=>'error','message'=>'DB Connection failed'])); }
$conn->set_charset("utf8");

$result = $conn->query("SELECT * FROM education ORDER BY start_year DESC");
$data = [];
while($row = $result->fetch_assoc()){ $data[] = $row; }
echo json_encode(['status'=>'success','data'=>$data]);
?>
