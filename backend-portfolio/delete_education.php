<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error){ die(json_encode(['status'=>'error','message'=>'DB Connection failed'])); }
$conn->set_charset("utf8");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$sql = "DELETE FROM education WHERE id=$id";
if($conn->query($sql)){ echo json_encode(['status'=>'success']); }
else{ echo json_encode(['status'=>'error','message'=>$conn->error]); }
?>
