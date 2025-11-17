<?php

require_once '../core/User.php';
require_once '../core/db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Username and password are required."]);
    exit();
}

$db = (new Database())->getConnection();
$user = new User($db);

$userData = $user->login($data->username, $data->password);

if ($userData) {
    session_start();
    $_SESSION['user_id'] = $userData['id'];
    http_response_code(200);
    echo json_encode(["message" => "Successfully logged in."]);
} else {
    http_response_code(401);
    echo json_encode(["message" => "Login failed."]);
}
