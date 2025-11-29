<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "You must be logged in to download files.";
    exit();
}

if (!isset($_GET['file_id'])) {
    http_response_code(400);
    echo "File ID is required.";
    exit();
}

if (!filter_var($_GET['file_id'], FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo "Invalid File ID.";
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
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file['type']);
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(404);
    echo "File not found or you don't have permission to access it.";
}
