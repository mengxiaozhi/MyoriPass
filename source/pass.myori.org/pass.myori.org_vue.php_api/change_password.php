<?php
require 'config.php';
session_start();
$user = $_SESSION['user'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    
    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }

    // 查询数据库中的用户数据并验证密码
    $query = "SELECT * FROM user WHERE email = '{$user['email']}'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedOldPassword = $row['password'];

        if (password_verify($oldPassword, $hashedOldPassword)) {
            // 旧密码验证成功，更新新密码
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE user SET password = '{$hashedNewPassword}' WHERE email = '{$user['email']}'";

            if ($conn->query($updateQuery) === TRUE) {
                $response = array(
                    "success" => true,
                    "message" => "密碼已更新成功。"
                );
                echo json_encode($response);
            } else {
                $response = array(
                    "success" => false,
                    "message" => "密碼更新失敗，未知錯誤。"
                );
                echo json_encode($response);
            }
        } else {
            $response = array(
                "success" => true,
                "message" => "舊密碼不正確。"
            );
            echo json_encode($response);
        }
    }

    $conn->close();
}

exit();