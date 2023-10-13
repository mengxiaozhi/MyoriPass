<?php 
require 'config.php';

$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';
    dbname=' . $config['dbname'] . ';
    charset=utf8',$config['username'],$config['password']
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; // 使用者名稱（可以是id或email）
    $password = $_POST['password'];

    $sql = $pdo->prepare('SELECT * FROM user WHERE id = ? OR email = ?');
    $sql->execute([$username, $username]);

    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user'] = $user; // 将用户信息存入会话
        if (isset($_POST['remember'])) {
            $session_lifetime = 180 * 24 * 60 * 60; // 180天的秒数
            session_set_cookie_params($session_lifetime);
        } else {
            // 如果没有勾选“保持登入”，将会话有效期设置为24分钟（1440秒）
            $session_lifetime = 24 * 60;
            session_set_cookie_params($session_lifetime);
            // 设置 PHP 会话的生命周期为24分钟
            ini_set('session.gc_maxlifetime', $session_lifetime);
        }
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