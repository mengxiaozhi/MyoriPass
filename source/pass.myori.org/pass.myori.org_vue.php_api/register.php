<?php 
require 'config.php';

$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';
    dbname=' . $config['dbname'] . ';
    charset=utf8',$config['username'],$config['password']
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $countries = $_POST["countries"];
    $id = $_POST['id'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 检查Email地址
    $emailCheckStmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE email = ?');
    $emailCheckStmt->execute([$email]);
    $emailExists = $emailCheckStmt->fetchColumn();

    if ($emailExists) {
        echo '該電子郵件地址已被註冊。';
    } else {
        $insertStmt = $pdo->prepare('INSERT INTO user (email, name, countries, id, password) VALUES (?, ?, ?, ?, ?)');
        if ($insertStmt->execute([$email, $name, $countries, $id, $hashedPassword])) {
            echo '註冊成功! <a href="https://pass.myori.org">去登入</a>';
        } else {
            echo '錯誤，請重試';
        }
    }
}