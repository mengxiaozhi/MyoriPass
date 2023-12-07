<?php 
require 'config.php';

$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';
    dbname=' . $config['dbname'] . ';
    charset=utf8',$config['username'],$config['password']
);
function generateRandomUid() {
    $uid = '';
    for ($i = 0; $i < 16; $i++) {
        $uid .= mt_rand(0, 9); // 生成随机数字
    }
    return $uid;
}

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

    $uids = [];
    for ($j = 0; $j < 52; $j++) {
        $uids[] = generateRandomUid();
    }

    if ($emailExists) {
        $response = array(
            "success" => true,
            "message" => "該電子郵件地址已被註冊。"
        );
    } else {
        $insertStmt = $pdo->prepare('INSERT INTO user (uid, email, name, countries, id, password) VALUES (?, ?, ?, ?, ?, ?)');
        if ($insertStmt->execute([$uids[0], $email, $name, $countries, $id, $hashedPassword])) {
            $response = array(
                "success" => true,
                "message" => "註冊成功!"
            );
        } else {
            $response = array(
                "success" => true,
                "message" => "錯誤，請重試."
            );
        }
    }
}

echo json_encode($response);
exit();