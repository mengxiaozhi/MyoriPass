<?php 
session_start();
?>
<body>
    <header>
        <button class="menu-btn" id="menu-btn2">
            <img src="/lib/img/icn_menu.svg" alt="Help" style="height: 27px; width: 27px;">
        </button>
        <button class="menu-btn">
            <div class="title">
                <a href="/">
                    <h1>MyoriPass</h1>
                </a>
            </div>
        </button>
        <button class="menu-btn">
            <a href="https://pass-view.myori.org/" target="_blank">
                <img src="/lib/img/icn_help.svg" alt="Help" style="height: 27px; width: 27px;">
            </a>
        </button>
    </header>
<!--header-->
<div class="hidden-menu-wrap animate__animated animate__fadeIn" id="hidden-menu">
    <div class="hidden-menu animate__animated animate__fadeInLeftBig">
        <div style="display:flex;justify-content: space-between;padding-left:30px;">
            <div style="display:flex">
                <img src="/lib/img/logo.png" alt="logo" style="height: 37px; width: 37px;padding-top:1em;padding-right:10px;">
                <h3 style="padding-top: 0;">MyoriPass 苗栗通</h3>
            </div>
            <button class="menu-btn" id="menu-close">
                <img src="/lib/img/icn_close.svg" alt="close" style="height: 27px; width: 27px;">
            </button>
        </div>
        <div class="menu-section">
            <?php
                if (isset($_SESSION['user'])) {
                    echo '  
                            <div style="background-color: #f3f4f5;">
                                <p>賬號管理</P>
                            </div>
                            <ul>
                                <li><a href="https://pass.myori.org/user/profile"><p>賬戶資料管理</p></a></li>
                                <li><a href="https://pass.myori.org/user/change_password"><p>更改登入密碼</p></a></li>
                                <li><a href="https://pass.myori.org/user/exit"><p>退出登入</p></a></li>
                            </ul>
                        ';
                }
            ?>
            <div style="background-color: #f3f4f5;">
                <p>App資訊</P>
            </div>
            <ul>
                <li><a href="/terms"><p>使用規約</p></a></li>
                <li><a href="/privacy"><p>個人隱私權條款</p></a></li>
            </ul>
            <p>版本資訊：<?php echo $app['version']?><br>
            Copyright© 苗栗國政府｜數位省<br>
            苗栗國（Myori）為網路虛擬國家
            </P>
        </div>
    </div>
</div>
<script>
     // 获取按钮和菜单的引用
    var menuBtn = document.getElementById("menu-btn2");
    var menuBtn2 = document.getElementById("menu-close");
    var hiddenMenu = document.getElementById("hidden-menu");

    // 添加点击事件监听器
    menuBtn.addEventListener('click', function() {
        // 切换菜单的显示状态
        if (hiddenMenu.style.display === 'none' || hiddenMenu.style.display === '') {
            hiddenMenu.style.display = 'block';
        } else {
            hiddenMenu.style.display = 'none';
        }
    });
    // 添加点击事件监听器
    menuBtn2.addEventListener('click', function() {
        // 切换菜单的显示状态
        if (hiddenMenu.style.display === 'none' || hiddenMenu.style.display === '') {
            hiddenMenu.style.display = 'block';
        } else {
            hiddenMenu.style.display = 'none';
        }
    });
</script>
<section>
<div style="padding-top: 100px;'">