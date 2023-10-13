<script>
    import 'animate.css';                   
    import axios from 'axios'
    import { RouterLink } from 'vue-router';

    export default {
    data() {
        return {
        menuVisible: false, // 初始菜单状态为隐藏
        status: 0 ,//初始管理界面为隐藏
        verstion: '',
        };
    },
    mounted() {
    // 在组件加载后，检查用户登录状态
    this.check_status();
    import('/src/assets/info.json').then(data => {
        this.verstion = data.verstion;
    });
    },
    methods: {
        toggleMenu() {
        // 切换菜单的显示状态
        this.menuVisible = !this.menuVisible;
        },
        check_status(){
            axios.get('/api/check_status.php').then(response => {
                this.status = response.data.status;
                console.log(response.data.message);
            });
        }
    }
    };
</script>

<template>
<header>
    <button @click="toggleMenu" class="menu-btn" id="menu-btn2">
        <img src="/icn_menu.svg" alt="Help" style="height: 27px; width: 27px;">
    </button>
    <button class="menu-btn">
        <div class="title">
            <RouterLink to="/">
                <h1>MyoriPass</h1>
            </RouterLink>     
        </div>
    </button>
    <button class="menu-btn">
        <a href="https://pass-view.myori.org/" target="_blank">
            <img src="/icn_help.svg" alt="Help" style="height: 27px; width: 27px;">
        </a>
    </button>
</header>
<!--header-->
<div v-if="menuVisible" class="hidden-menu-wrap animate__animated animate__fadeIn" id="hidden-menu">
<div class="hidden-menu animate__animated animate__fadeInLeftBig">
    <div style="display:flex;justify-content: space-between;padding-left:30px;">
        <div style="display:flex">
            <img src="/logo.png" alt="logo" style="height: 37px; width: 37px;padding-top:1em;padding-right:10px;">
            <h3 style="padding-top: 0;">MyoriPass 苗栗通</h3>
        </div>
        <button @click="toggleMenu" class="menu-btn" id="menu-close">
            <img src="/icn_close.svg" alt="close" style="height: 27px; width: 27px;">
        </button>
    </div>
    <div class="menu-section">
        <div v-if="status === 1">
            <div style="background-color: #f3f4f5;">
            <p>賬號管理</P>
            </div>
            <ul>
                <li><a href="https://pass.myori.org/user/profile"><p>賬戶資料管理</p></a></li>
                <li><a href="https://pass.myori.org/user/change_password"><p>更改登入密碼</p></a></li>
                <li><a href="https://pass.myori.org/user/exit"><p>退出登入</p></a></li>
            </ul>
        </div>
        <div style="background-color: #f3f4f5;">
            <p>App資訊</P>
        </div>
        <ul>
            <li><RouterLink to="terms"><p>使用規約</p></RouterLink></li>
            <li><RouterLink to="privacy"><p>個人隱私權條款</p></RouterLink></li>
        </ul>
        <p>版本資訊：{{ verstion }}<br>
        Copyright© 苗栗國政府｜數位省<br>
        苗栗國（Myori）為網路虛擬國家
        </P>
    </div>
</div>
</div>
</template>