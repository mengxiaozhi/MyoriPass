<?php 
require '../config.php';
require '../partial/head.php';
require '../partial/header.php';

$user = $_SESSION['user'];  // 将用户信息存入会话

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

        // 判断是否更新了电子邮箱
        if ($email !== $user['email']) {
            // 检查新的电子邮箱是否已存在
            $emailCheckStmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE email = ?');
            $emailCheckStmt->execute([$email]);
            $emailExists = $emailCheckStmt->fetchColumn();

            if ($emailExists) {
                echo '該電子郵件地址已被註冊。';
            } else {
                $updateStmt = $pdo->prepare('UPDATE `user` SET `email`=?, `name`=?, `countries`=?, `id`=? WHERE `email` = ?');
                if ($updateStmt->execute([$email, $name, $countries, $id, $user['email']])) {
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['countries'] = $countries;
                    $_SESSION['user']['id'] = $id;
                    echo '更新成功!</a>';
                    echo'
                    <script>
                        setTimeout(function() {
                            window.location.href = "profile";
                        }, 1500); 
                    </script>
                    ';
                } else {
                    echo '錯誤，請重試';
                }
            }
        } else {
            // 未更新电子邮箱，直接更新其他信息
            $updateStmt = $pdo->prepare('UPDATE `user` SET `name`=?, `countries`=?, `id`=? WHERE `email` = ?');
            if ($updateStmt->execute([$name, $countries, $id, $user['email']])) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['countries'] = $countries;
                $_SESSION['user']['id'] = $id;
                echo '更新成功!';
                echo'
                <script>
                    setTimeout(function() {
                        window.location.href = "profile";
                    }, 1500); 刷新页面
                </script>
                ';
            } else {
                echo '錯誤，請重試';
            }
        }
    }
?>
<h2>管理MyoriPas賬號資料</h2>
<h3 class="title-section">更新帳號基本資料</h3>
<form action="profile" method="post" onsubmit="return validatePassword();">
    <div>
        <label><h3>Email</h3></label>
        <input type="email" name="email" placeholder="Email" maxlength="128" onkeyup="this.value=this.value.replace(/\s+/g,'')" value="<?php echo $user['email']; ?>" required>
    </div>
    <div>
        <label><h3>姓名</h3></label>
        <input type="text" name="name" placeholder="姓名" pattern=".{2,}$" maxlength="32" onkeyup="this.value=this.value.replace(/\s+/g,'')" value="<?php echo $user['name']; ?>" required>
    </div>
    <div>
        <label for="options"><h3>國籍</h3></label>
        <select name="countries" required>
                    <option value="">請選擇國家</option>
                    <?php 
                        $jsonFilePath = '../lib/countries.json';
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
                            $selected = ($country['ISO代碼'] === $user['countries']) ? 'selected' : '';
                            echo '<option value="' . $country['ISO代碼'] . '" ' . $selected . '>' . $country['國家/地區'] . '</option>';
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
        <?php
            if ($user['countries'] === "MAL") {
                echo '<p>・ 國籍為苗栗國或東亞聯邦成員國，根據「苗栗國個人資料管理條例」無法修改證件資料</p>';
                echo '<input type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9" disabled="disabled" onkeyup="this.value=this.value.replace(/\s+/g,\'\')" value="', $user['id'], '">';
            } else {
                echo '<input type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9" onkeyup="this.value=this.value.replace(/\s+/g,\'\')" value="', $user['id'], '">';
            }
        ?>
    </div>
    <div>
        <button type="submit" class="btn btn-default icn_button" id="login">
            <img src="../lib/img/icn_update.svg" alt="warning">
            <h3>更新帳號資料</h3>
        </button>
    </div>
</form>
<h3 class="title-section">個人資料管理</h3>
<div class="register">
    <a href="download_data.php">
        <button class="btn btn-default icn_button">
            <img src="../lib/img/icn_download.svg" alt="dowload">
            <h3>下載賬號個資</h3>
        </button>
    </a>
</div>
<div class="warning">
        <button class="btn btn-default icn_button" id="delete">
            <img src="../lib/img/icn_attention.svg" alt="warning">
            <h3>刪除全部資料</h3>
        </button>
</div>
<div id="hidden-window" style="display:none">
    <h2>刪除全部資料</h2>
    <h3 class="title-section">驗證密碼</h3>
            <div>
                <form action="delete.php" method="post">
                    <div style="display:none;">
                        <label><h3>MyNumber編號 或 Email地址</h3></label>
                        <input type="text" name="username" placeholder="MyNumber編號 & Email"  value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div>
                        <label><h3>密碼</h3></label>
                        <input type="password" name="password" placeholder="密碼" required>
                    </div>
                    <div class="warning">
                        <button class="btn btn-default icn_button" id="delete">
                            <img src="../lib/img/icn_attention.svg" alt="warning">
                            <h3>確認刪除資料</h3>
                        </button>
                    </div>
                </form>
                </div>
            </div>  
</div>
<script>
     // 获取按钮和菜单的引用
    var deleteBtn = document.getElementById("delete");
    var hiddenwindow = document.getElementById("hidden-window");

    // 添加点击事件监听器
    deleteBtn.addEventListener('click', function() {
        // 切换菜单的显示状态
        if (hiddenwindow.style.display === 'none' || hiddenwindow.style.display === '') {
            hiddenwindow.style.display = 'block';
        } else {
            hiddenwindow.style.display = 'none';
        }
    });
    // 添加点击事件监听器
    hidden-window.addEventListener('click', function() {
        // 切换菜单的显示状态
        if (hiddenwindow.style.display === 'none' || hiddenwindow.style.display === '') {
            hiddenwindow.style.display = 'block';
        } else {
            hiddenwindow.style.display = 'none';
        }
    });
</script>
<?php
require '../partial/footer.php';
?>