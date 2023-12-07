<?php 
require '../config.php';
require '../partial/head.php';
require '../partial/header.php'; 

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
        echo '
            <script type="text/javascript">
                window.location.href = "/user";
            </script>
        ';
    } else {
        echo '登入ID或密碼有誤。';
    }    
}
?>

<h2>登入MyoriPass</h2>
<h3 class="title-section">關於使用</h3>
<p style="display: flex;justify-content: center;">
提交登入即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。<br>
</p>
<h3 class="title-section">輸入帳號資料</h3>
        <div>
            <form action="login" method="post">
                <div>
                    <label><h3>MyNumber編號 或 Email地址</h3></label>
                    <input type="text" name="username" placeholder="MyNumber編號 & Email" required>
                </div>
                <div>
                    <label><h3>密碼</h3></label>
                    <input type="password" name="password" placeholder="密碼" required>
                </div>
                <div style="display:flex;height: 37px;margin-top: 17px;">
                    <input type="checkbox" name="remember" value="remember">
                    <label>
                        <p style="line-height: 37px;margin-left:10px;margin-block-start: 0;margin-block-end: 0;">保持登入狀態</p>
                    </label>
                </div>
                <div class="button">
                    <button type="submit" class="btn btn-default" id="login"><h3>登入</h3></button>
                </div>
            </form>
            </div>
        </div>  

<?php require '../partial/footer.php'; ?>