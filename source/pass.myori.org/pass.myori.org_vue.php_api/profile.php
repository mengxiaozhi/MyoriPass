<?php 
require 'config.php';
session_start();
$user = $_SESSION['user'];  // 将用户信息存入会话

$s_email = $user['email'];
$s_name = $user['name'];
$s_countries = $user["countries"];
$s_id = $user['id'];

$response = array(
    "success" => true,
    "email" => $s_email,
    "name" => $s_name,
    "countries" => $s_countries,
    "id" => $s_id
);
echo json_encode($response);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $pdo = new PDO(
            'mysql:host=' . $config['host'] . ';
            dbname=' . $config['dbname'] . ';
            charset=utf8',$config['username'],$config['password']
        );
    
        $email = $_POST['email'];
        $name = $_POST['name'];
        $countries = $_POST["countries"];
        $id = $_POST['id'];

        // 判断是否更新了电子邮箱
        if ($email !== $user['email']) {
            // 检查新的电子邮箱是否已存在
            $emailCheckStmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE email = ?');
            $emailCheckStmt->execute([$email]);
            $emailExists = $emailCheckStmt->fetchColumn();

            if ($emailExists) {
                $response = array(
                    "success" => true,
                    "message" => "該電子郵件地址已被註冊。"
                );
                echo json_encode($response);
            } else {
                $updateStmt = $pdo->prepare('UPDATE `user` SET `email`=?, `name`=?, `countries`=?, `id`=? WHERE `email` = ?');
                if ($updateStmt->execute([$email, $name, $countries, $id, $user['email']])) {
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['countries'] = $countries;
                    $_SESSION['user']['id'] = $id;
                    
                    $response = array(
                        "success" => true,
                        "message" => "更新成功!"
                    );
                    echo json_encode($response);
                } else {
                    $response = array(
                        "success" => true,
                        "message" => "錯誤，請重試。"
                    );
                    echo json_encode($response);
                }
            }
        } else {
            // 未更新电子邮箱，直接更新其他信息
            $updateStmt = $pdo->prepare('UPDATE `user` SET `name`=?, `countries`=?, `id`=? WHERE `email` = ?');
            if ($updateStmt->execute([$name, $countries, $id, $user['email']])) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['countries'] = $countries;
                $_SESSION['user']['id'] = $id;
                
                $response = array(
                    "success" => true,
                    "message" => "更新成功!"
                );
                echo json_encode($response);
            } else {
                $response = array(
                    "success" => true,
                    "message" => "錯誤，請重試。"
                );
                echo json_encode($response);
            }
        }
    }

    exit();