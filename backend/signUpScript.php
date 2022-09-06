<?php
include 'script/functions.php';
header('Content-Type: application/json');
$content = json_decode(stripslashes(file_get_contents('php://input')), true);

extract($content);


$response = createUser($username,$email, $password);

echo json_encode(['response'=>$response]);