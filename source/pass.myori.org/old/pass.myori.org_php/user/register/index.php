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
    <h2>注冊MyoriPass</h2>
        <div>
            <h3 class="title-section">關於使用</h3>
            <p style="display: flex;justify-content: center;">
            提交申請即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。<br>
            如果您的國籍不屬於苗栗國或東亞聯邦成員國，您注冊時將不需要填寫證件碼。
            </p>
            <h3 class="title-section">輸入帳號資料</h3>
            <form action="index" method="post" onsubmit="return validatePassword();">
            <div>
                <label><h3>Email</h3></label>
                <input type="email" name="email" placeholder="Email" maxlength="128" onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label><h3>姓名</h3></label>
                <input type="text" name="name" placeholder="姓名" pattern=".{2,}$" maxlength="32" onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label for="options"><h3>國籍</h3></label>
                <select name="countries" required>
                    <option value="">請選擇國家</option>
                    <?php 
                        $jsonFilePath = '../../lib/countries.json';
                        // 检查文件是否存在
                        if (file_exists($jsonFilePath)) {
                        // 读取 JSON 文件的内容
                        $jsonContent = file_get_contents($jsonFilePath);
                        // 解析 JSON
                        $countries = json_decode($jsonContent, true);
                        // 验证 JSON 解析是否成功
                        if ($countries !== null) {
                        // 填充下拉选单
                        foreach ($countries as $country) {
                            echo '<option value="' . $country['ISO代碼'] . '">' . $country['國家/地區'] . '</option>';
                        }
                        } else {
                            echo '<option value="">无法解析 JSON 数据</option>';
                        }
                        } else {
                        echo '<option value="">JSON 文件不存在</option>';
                        }
                    ?>
                </select>
            </div>
            <div name="id">
                <label><h3>MyNumber編號/護照號碼</h3></label>
                <input type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9" onkeyup="this.value=this.value.replace(/\s+/g,'')">
            </div>
            <div>
                <label><h3>密碼</h3></label>
                <p>
                    ・ 10個字元以上<br>
                    ・ 大寫英文+小寫英文+數字+符號的組合<br>
                    ・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_
                </p>
                <input type="password" name="password" placeholder="密碼" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
            </div>
            <div>
                <label><h3>確認密碼</h3></label>
                <input type="password" name="confirm_password" placeholder="確認密碼" onkeyup="this.value=this.value.replace(/\s+/g,'')" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
            </div>
                <div>
                    <button type="submit" class="btn btn-default" id="login"><h3>註冊新帳號</h3></button>
                </div>
            </form>
            <div class="register">
                <a href="digital"><button class="btn btn-default"><h3>註冊成爲數位公民</h3></button></a>
            </div>
        </div>
        <script type="text/javascript" src="../../lib/detect_MAL.js" ></script>

<?php require '../../partial/footer.php'; ?>      