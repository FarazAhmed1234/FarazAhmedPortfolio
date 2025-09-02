<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$hashed = password_hash($password,PASSWORD_DEFAULT);

$conn = new mysqli("localhost","root","","portfolio_db");
$stmt = $conn->prepare("UPDATE admin_users SET password=?, otp=NULL WHERE email=?");
$stmt->bind_param("ss",$hashed,$email);

if($stmt->execute()){
    echo json_encode(['success'=>true,'message'=>'Password reset successfully']);
}else{
    echo json_encode(['success'=>false,'message'=>'Failed to reset password']);
}
?>
