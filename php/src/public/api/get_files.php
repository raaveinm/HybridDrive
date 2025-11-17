<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "You must be logged in to view files."]);
    exit();
}

require_once '../core/db.php';

$user_id = $_SESSION['user_id'];

$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT id, name, size, type, created_at FROM files WHERE user_id = ?");
$stmt->execute([$user_id]);

$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($files);
