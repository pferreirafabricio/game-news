<?php

require_once './vendor/autoload.php';
require_once './source/Core/Headers.php';

parse_str(file_get_contents('php://input'), $data);
$uri = $_SERVER["REQUEST_URI"];

echo json_decode(file_get_contents('php://input'));

// echo json_encode([
//     "data" => $data,
//     "uri" => $uri
// ]);