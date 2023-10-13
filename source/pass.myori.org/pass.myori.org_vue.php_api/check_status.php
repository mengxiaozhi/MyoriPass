<?php
if (isset($_SESSION['user'])) {
    // 用户已登录
    $response = array(
        "success" => true,
        "status" => 1,
        "message" => "用户已登录。"
    );
} else {
    // 用户未登录
    $response = array(
        "success" => false,
        "status" => 0,
        "message" => "用户未登录。"
    );
}

echo json_encode($response);

exit();