<?php 
require '/config.php';

$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';
    dbname=' . $config['dbname'] . ';
    charset=utf8',$config['username'],$config['password']
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $countries = $_POST["countries"];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 生成用户ID
    $randomDigits = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $userId = "000" . $randomDigits;

    // 检查Email地址
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
        $insertStmt = $pdo->prepare('INSERT INTO user (email, name, countries, id, password) VALUES (?, ?, ?, ?, ?)');
        if ($insertStmt->execute([$email, $name, $countries, $userId, $hashedPassword])) {
            $response = array(
                "success" => true,
                "message" => "註冊成功! "
            );
            echo json_encode($response);
        } else {
            $response = array(
                "success" => true,
                "message" => "錯誤，請重試."
            );
            echo json_encode($response);
        }
    }
}
exit();