<?php 
require 'config.php';

session_start();
$user = $_SESSION['user'];  // 将用户信息存入会话

$response = array(
    "success" => true,
    "email" => $user['email'],
    "name" => $user['name'],
    "countries" => $user['cpuntries'],
    "id" => $user['id']
);
echo json_encode($response);

exit();