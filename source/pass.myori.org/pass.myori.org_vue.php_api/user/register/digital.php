<?php 
require '../../config.php';
require '../../partial/head.php';
require '../../partial/header.php';

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
        echo '該電子郵件地址已被註冊。';
    } else {
        $insertStmt = $pdo->prepare('INSERT INTO user (email, name, countries, id, password) VALUES (?, ?, ?, ?, ?)');
        if ($insertStmt->execute([$email, $name, $countries, $userId, $hashedPassword])) {
            echo '註冊成功! <a href="https://pass.myori.org">去登入</a>';
        } else {
            echo '錯誤，請重試';
        }
    }
}
?>

<script type="text/javascript">
    function validatePassword() {
    var password = document.querySelector("input[name=password]").value;
    var confirmPassword = document.querySelector("input[name=confirm_password]").value;

    if (password !== confirmPassword) {
        alert("密碼與確認密碼不符，請重新輸入。");
        return false;
    }
    return true;
}
</script>

        <h2>注冊成爲苗栗國數位公民</h2>
        <h3 class="title-section">關於使用</h3>
        <p style="display: flex;justify-content: center;">
            提交申請即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。<br>
            *此表單為數字公民身份申請表，並不具備完整的公民權利，我們也不會將您的資料納入我們的國民系統不會给予您My Number編號。如果您後續想成爲苗栗國公民，請準備您的身份證明文件進行KYC以及填寫入籍申請表，審核完成後入籍即成爲苗栗國公民。<br>
            *注意，數位公民身份和外國人身份可以同時存在，如果您已經具備了外國人賬號請使用其他Email進行注冊或直接使用原賬號進行身份轉換，Email為數位公民身份的唯一憑證。
        </p>
        <div class='register-form'>
            <h3 class="title-section">輸入帳號資料</h3>
            <form action="digital" method="post">
            <div>
                <label><h3>Email</h3></label>
                <input type="email" name="email" placeholder=Email maxlength="128" onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label><h3>姓名</h3></label>
                <input type="text" name="name" placeholder="姓名" pattern=".{2,}$" maxlength="32" onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label for="options"><h3 >國籍</h3></label>
                <select name="countries" required>
                    <option value="MAL">苗栗（數位）</option>
                </select>
            </div>
            <div>
                <label><h3>密碼</h3></label>
                <p>
                    ・ 10個字元以上<br>
                    ・ 大寫英文+小寫英文+數字+符號的組合<br>
                    ・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_
                </p>
                <input type="password" name="password" placeholder="密碼" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$"  required>
            </div>
            <div>
                <label><h3>確認密碼</h3></label>
                <input type="password" name="confirm_password" placeholder="確認密碼" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$"  required>
            </div>
            <div>
                <button type="submit" class="btn btn-default" id="login"><h3>註冊數位公民</h3></button>
            </div>
            </form>
        </div>
        
<?php require '../../partial/footer.php'; ?>       