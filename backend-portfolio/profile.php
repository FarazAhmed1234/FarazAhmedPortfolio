<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";       // your DB username
$pass = "";           // your DB password
$db   = "portfolio_db";  // your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die(json_encode(["success" => false, "message" => "DB connection failed."]));
}

$action = $_POST["action"] ?? ($_GET["action"] ?? "");

// ---------- GET PROFILE ----------
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $sql = "SELECT * FROM profile LIMIT 1";
  $res = $conn->query($sql);
  if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    // return full path for avatar
    if ($row["avatar"]) {
      $row["avatar"] = "backend-portfolio/uploads/" . $row["avatar"];
    }
    echo json_encode($row);
  } else {
    echo json_encode(null);
  }
  exit;
}

// ---------- SAVE PROFILE ----------
if ($action === "save") {
  $id = $_POST["id"] ?? 0;
  $name = $conn->real_escape_string($_POST["name"] ?? "");
  $skills = $conn->real_escape_string($_POST["skills"] ?? "");
  $details = $conn->real_escape_string($_POST["details"] ?? "");

  $avatarFile = null;

  if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    $filename = uniqid("avatar_") . "." . $ext;
    $target = __DIR__ . "/uploads/" . $filename;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
      $avatarFile = $filename;
    }
  }

  if ($id > 0) {
    // update
    if ($avatarFile) {
      $sql = "UPDATE profile SET name='$name', skills='$skills', details='$details', avatar='$avatarFile' WHERE id=$id";
    } else {
      $sql = "UPDATE profile SET name='$name', skills='$skills', details='$details' WHERE id=$id";
    }
  } else {
    // insert
    $sql = "INSERT INTO profile (name, skills, details, avatar) VALUES ('$name','$skills','$details','$avatarFile')";
  }

  if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => $conn->error]);
  }
  exit;
}

// ---------- DELETE PROFILE ----------
if ($action === "delete") {
  $id = $_POST["id"] ?? 0;
  if ($id > 0) {
    $sql = "DELETE FROM profile WHERE id=$id";
    $conn->query($sql);
  }
  echo json_encode(["success" => true]);
  exit;
}

echo json_encode(["success" => false, "message" => "Invalid request."]);
