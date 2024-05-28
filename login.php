<?php 
require 'config.php';

$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';
    dbname=' . $config['dbname'] . ';
    charset=utf8', $config['username'], $config['password']
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; // 使用者名稱（可以是id或email）
    $password = $_POST['password'];

    $sql = $pdo->prepare('SELECT * FROM user WHERE id = ? OR email = ?');
    $sql->execute([$username, $username]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        if (isset($_POST['remember'])) {
            $session_lifetime = 180 * 24 * 60 * 60; // 180天的秒數
        } else {
            // 如果沒有勾選“保持登入”，將會話有效期設為24分鐘（1440秒）
            $session_lifetime = 24 * 60;
        }
        
        session_set_cookie_params([
            'lifetime' => $session_lifetime,
            'path' => '/',
            'domain' => '.myori.org',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        // 現在開始會話
        session_start();
        $_SESSION['user'] = $user; // 將用戶信息存入會話

        $response = array(
            "success" => true,
            "status" => 1,
            "message" => "登入成功。"
        );
    } else {
        $response = array(
            "success" => false,
            "status" => 0,
            "message" => "登入ID或密碼有誤。"
        );
    }

    echo json_encode($response);
}

exit();