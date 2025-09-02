<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

$conn=new mysqli("localhost","root","","portfolio_db");
if($conn->connect_error) die(json_encode(["success"=>false,"message"=>$conn->connect_error]));

$id=$_POST['id']??0;
$name=$_POST['name']??'';
$category_name=$_POST['category_name']??'';
$description=$_POST['description']??'';
$tech_stack=$_POST['tech_stack']??'';
$live_url=$_POST['live_url']??'';
$github_url=$_POST['github_url']??'';
$imageName=null;

if(!$id||!$name||!$category_name){ echo json_encode(["success"=>false,"message"=>"ID, name & category required"]); exit; }

$catResult=$conn->query("SELECT name FROM categories WHERE id='$category_name' LIMIT 1");
$category_name="";
if($catResult && $catResult->num_rows>0){ $row=$catResult->fetch_assoc(); $category_name=$row['name']; }

if(isset($_FILES['image']) && $_FILES['image']['error']===0){
    $imageName=time()."_".basename($_FILES["image"]["name"]);
    $target="uploads/".$imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"],$target);
    $imgSql=", image='$imageName'";
}else{
    $imgSql="";
}

$sql="UPDATE projects 
      SET name='$name', category_name='$category_name', description='$description',
          tech_stack='$tech_stack', live_url='$live_url', github_url='$github_url' $imgSql
      WHERE id=$id";

echo $conn->query($sql)
 ? json_encode(["success"=>true,"message"=>"Project updated successfully"])
 : json_encode(["success"=>false,"message"=>$conn->error]);
?>
