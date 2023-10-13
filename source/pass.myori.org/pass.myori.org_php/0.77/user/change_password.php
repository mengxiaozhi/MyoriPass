<?php
require '../config.php';
require '../partial/head.php';
require '../partial/header.php';

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
                echo '<p>密碼已更新成功。</p>';
            } else {
                echo '<p>密碼更新失敗，未知錯誤。</p>';
            }
        } else {
            echo '<p>舊密碼不正缺。</p>';
        }
    }

    $conn->close();
}
?>

<script type="text/javascript">
    function validatePassword() {
    var password = document.querySelector("input[name=new_password]").value;
    var confirmPassword = document.querySelector("input[name=confirm_password]").value;

    if (password !== confirmPassword) {
        alert("密碼與確認密碼不符，請重新輸入。");
        return false;
    }
    return true;
}
</script>

<h2>修改MyoriPas登入密碼</h2>
<h3 class="title-section">輸入帳號資料</h3>
<form action="change_password" method="post">
    <div class="old-password">
        <label for="old_password"><h3>舊密碼</h3></label>
        <input type="password" name="old_password" required>
    </div>
    <div class="new-password">
        <label for="new_password"><h3>新密碼</h3></label>
        <p>
            ・ 10個字元以上<br>
            ・ 大寫英文+小寫英文+數字+符號的組合<br>
            ・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_
        </p>
        <input type="password" name="new_password" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
    </div>
    <div class="confirm-password">
        <label for="confirm_password"><h3>確認新密碼</h3></label>
        <input type="password" name="confirm_password" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
    </div>
    <div>
        <button type="submit" class="btn btn-default icn_button" id="login">
            <img src="../lib/img/icn_update.svg" alt="warning">
            <h3>更新登入密碼</h3>
        </button>
    </div>
</form>

<?php require '../partial/footer.php'; ?>