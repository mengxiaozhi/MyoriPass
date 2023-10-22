<?php
// 在一切开始之前启动会话
session_start();

// 您可以添加一行来检查和记录会话数据，帮助调试
error_log('Session Data: ' . print_r($_SESSION, true));  // 将会话数据记录到错误日志

// 检查用户是否已经登录
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    // 用户已登录
    $response = array(
        "success" => true,
        "status" => 1,
        "message" => "用户已登录。",
        "user" => $_SESSION['user']  // 可选，如果您想返回用户数据
    );
} else {
    // 没有登录信息
    $response = array(
        "success" => false,
        "status" => 0,
        "message" => "用户未登录。"
    );
}

// 返回 JSON 响应
header('Content-Type: application/json');
echo json_encode($response);

// 结束脚本执行
exit();