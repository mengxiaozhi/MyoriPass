<?php
require '../config.php';
require '../partial/head.php';
require '../partial/header.php';

// 检查用户是否已登录
if (!isset($_SESSION['user'])) {
    echo '
        <script type="text/javascript">
            window.location.href = "../";
        </script>
    ';
    exit();
} else {

    $pdo = new PDO(
        'mysql:host=' . $config['host'] . ';
        dbname=' . $config['dbname'] . ';
        charset=utf8',$config['username'],$config['password']
    );    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username']; // 使用者名稱（可以是id或email）
        $password = $_POST['password'];

        // 使用预处理语句来防止 SQL 注入漏洞
        $sql = $pdo->prepare('SELECT * FROM user WHERE id = ? OR email = ?');
        $sql->execute([$username, $username]);

        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $email = $_SESSION['user']['email'];

            // 删除用户的帐户
            $deleteStmt = $pdo->prepare('DELETE FROM user WHERE email = ?');
            if ($deleteStmt->execute([$email])) {
                // 注销用户
                session_unset();
                session_destroy();
                echo '
                所有資料皆已完成刪除，如需再次使用本服務請重新注冊。
                <script type="text/javascript">
                    setTimeout(function() {
                        window.location.href = "../";
                    }, 3000); // 设置延迟时间为3秒（3000毫秒）
                </script>
            ';            
                exit();
            } else {
                echo '删除帐户时出错，请重试。';
            }
        } else {
            echo '用户名或密码不正确。'; // 用户名或密码错误时返回错误消息
        }
    }
}
require '../partial/footer.php';
?>