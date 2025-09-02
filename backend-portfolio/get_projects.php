<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn=new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error) die(json_encode(["success"=>false,"message"=>$conn->connect_error]));

$res=$conn->query("SELECT * FROM projects ORDER BY id DESC");
$data=[];
while($row=$res->fetch_assoc()){ $data[]=$row; }
echo json_encode($data);
?>
