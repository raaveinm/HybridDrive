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
