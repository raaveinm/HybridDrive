<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "You must be logged in to delete files."]);
    exit();
}

if (!isset($_GET['file_id'])) {
    http_response_code(400);
    echo json_encode(["message" => "File ID is required."]);
    exit();
}

/**
 * @return array
 */
function db_init_()
{
    require_once '/var/www/html/core/db.php';

    $user_id = $_SESSION['user_id'];
    $file_id = $_GET['file_id'];

    $db = (new Database())->getConnection();
    $stmt = $db->prepare("SELECT * FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$file_id, $user_id]);

    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    return array($file_id, $db, $stmt, $file);
}

list($file_id, $db, $stmt, $file) = db_init_();

if ($file) {
    $file_path = $file['path'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $stmt = $db->prepare("DELETE FROM files WHERE id = ?");
    if ($stmt->execute([$file_id])) {
        http_response_code(200);
        echo json_encode(["message" => "File was successfully deleted."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Unable to delete file from the database."]);
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "File not found or you don't have permission to delete it."]);
}
