<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn=new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error) die(json_encode(["success"=>false,"message"=>$conn->connect_error]));

$id=$_GET['id']??0;
if(!$id){ echo json_encode(["success"=>false,"message"=>"ID required"]); exit; }

$sql="DELETE FROM projects WHERE id=$id";
echo $conn->query($sql)
 ? json_encode(["success"=>true,"message"=>"Project deleted successfully"])
 : json_encode(["success"=>false,"message"=>$conn->error]);
?>
