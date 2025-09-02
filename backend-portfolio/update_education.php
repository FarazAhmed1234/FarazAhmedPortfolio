<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error){ die(json_encode(['status'=>'error','message'=>'DB Connection failed'])); }
$conn->set_charset("utf8");

$id = $_POST['id'];
$name = $_POST['name'];
$start_year = $_POST['start_year'];
$end_year = $_POST['end_year'];
$institution = $_POST['institution'];

$sql = $conn->prepare("UPDATE education SET name=?, start_year=?, end_year=?, institution=? WHERE id=?");
$sql->bind_param("siisi",$name,$start_year,$end_year,$institution,$id);

if($sql->execute()){ echo json_encode(['status'=>'success']); }
else{ echo json_encode(['status'=>'error','message'=>$conn->error]); }
?>
