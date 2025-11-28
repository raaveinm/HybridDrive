<?php

require_once '/var/www/html/core/User.php';
require_once '/var/www/html/core/db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Username and password are required."]);
    exit();
}

$db = (new Database())->getConnection();
$user = new User($db);

if ($user->register($data->username, $data->password)) {
    http_response_code(201);
    echo json_encode(["message" => "User was successfully registered."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Unable to register the user."]);
}
