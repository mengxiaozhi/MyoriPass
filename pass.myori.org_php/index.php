<?php
require 'config.php';
require 'partial/head.php';
require 'partial/header.php';

    if (isset($_SESSION['user'])) {
        // 用户已登录
        $user = $_SESSION['user'];
        echo'
            <script type="text/javascript">
                window.location.href = "/user";
            </script>
        ';
    } else {
        // 用户未登录
        echo'
        <h1>MyoriPass<br>苗栗通</h1>
        <div style="display: flex; justify-content: center; margin-bottom:37px;margin-top:37px">
            <img src="lib/img/m_12_white.png" alt="logo" style="width: 100%;">
        </div>
        <div>
                <div class="button">
                <a href="/user/login"><button class="btn btn-default" id="login"><h3>登入現有賬號</h3></button></a>
                </div>
                <div class="register">
                    <a href="/user/register"><button class="btn btn-default"><h3>註冊新的帳號</h3></button></a>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: center;">
            <p>
            使用前請閲讀
            <a href="/terms">使用規約</a> 及 <a href="/privacy">個人隱私權條款</a>
            </p>
        </div>
        ';
    }

require 'partial/footer.php';