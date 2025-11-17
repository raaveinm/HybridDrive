<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "You must be logged in to upload files."]);
    exit();
}

if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(["message" => "No file was uploaded."]);
    exit();
}

require_once '../core/db.php';

$user_id = $_SESSION['user_id'];
$file = $_FILES['file'];

$upload_dir = "/var/www/html/uploads/" . $user_id;
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_path = $upload_dir . "/" . basename($file['name']);

if (move_uploaded_file($file['tmp_name'], $file_path)) {
    $db = (new Database())->getConnection();
    $stmt = $db->prepare("INSERT INTO files (user_id, name, path, size, type) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $file['name'], $file_path, $file['size'], $file['type']])) {
        http_response_code(201);
        echo json_encode(["message" => "File was successfully uploaded."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Unable to save file information to the database."]);
    }
} else {
    http_response_code(500);
    echo json_encode(["message" => "Unable to upload the file."]);
}
