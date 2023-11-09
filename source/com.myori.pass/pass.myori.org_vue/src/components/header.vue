<script setup>
import { ref, onMounted, computed } from 'vue';
import { useUserStore } from '@/store/userStore';
import { useRouter } from 'vue-router';
import info from '@/assets/info.json';
import axios from 'axios';
import 'animate.css';

const router = useRouter();
// 用戶狀態管理
const userStore = useUserStore();
// 版本資訊
const version = ref('');
// 用戶登入狀態
const status = computed(() => userStore.status);

// 控制菜單可見性
const menuVisible = ref(false);

onMounted(() => {
    if (info && info.version) {
        version.value = info.version;
    } else {
        console.error("版本號錯誤");
    }
});

// 切換菜單可見性
const toggleMenu = () => {
    menuVisible.value = !menuVisible.value;
};

// 點擊標題跳轉
const handleTitleClick = () => {
    router.push(status.value === 1 ? '/user' : '/');
};

// 用戶登出
const logoutUser = async () => {
    try {
        const response = await axios.get('https://pass.myori.org/api/exit.php');
        if (response.data.status === 'success') {
            userStore.clearUser();
            userStore.setStatus(0);
            menuVisible.value = false;
            router.push('/');
        } else {
            throw new Error('登出失敗');
        }
    } catch (error) {
        console.error('登出過程中出錯:', error);
    }
};
</script>




<template>
    <header>
        <button @click="toggleMenu" class="menu-btn" id="menu-btn2">
            <img src="/icn_menu.svg" alt="Help" style="height: 27px; width: 27px;">
        </button>
        <button class="menu-btn" @click="handleTitleClick">
            <div class="title">
                <h1>MyoriPass</h1>
            </div>
        </button>
            <button  v-if="status === 0" class="menu-btn">
                <a href="https://pass-view.myori.org/" target="_blank">
                    <img src="/icn_help.svg" alt="Help" style="height: 27px; width: 27px;">
                </a>
            </button>
            <button v-if="status === 1" class="menu-btn">
                <RouterLink to="/user/reader">
                    <img src="/icn_reader.svg" alt="QR-Code_Reader" style="height: 27px; width: 27px;">
                </RouterLink>
            </button>
    </header>
    <!--header-->
    <div v-if="menuVisible" class="menuVisible hidden-menu-wrap animate__animated animate__fadeIn" @click="closeOnOverlay">
        <div class="hidden-menu animate__animated animate__fadeInLeftBig" @click.stop>
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
                        <li @click="toggleMenu">
                            <RouterLink to="/user/profile">
                                <p>賬戶資料管理</p>
                            </RouterLink>
                        </li>
                        <li @click="toggleMenu">
                            <RouterLink to="/user/password">
                                <p>更改登入密碼</p>
                            </RouterLink>


                        </li>
                        <li @click="logoutUser" style="cursor: pointer;">
                            <a>
                                <p>退出登入</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="background-color: #f3f4f5;">
                    <p>App資訊</P>
                </div>
                <ul>
                    <li @click="toggleMenu">
                        <RouterLink to="/terms">
                            <p>使用規約</p>
                        </RouterLink>
                    </li>
                    <li @click="toggleMenu">
                        <RouterLink to="/privacy">
                            <p>個人隱私權條款</p>
                        </RouterLink>
                    </li>
                </ul>
                <p>版本資訊：{{ version }}<br>
                    Copyright© 苗栗國政府｜數位省<br>
                    苗栗國（Myori）為網路虛擬國家
                </P>
            </div>
        </div>
    </div>
</template>
<style>
li:hover{
    background-color: #f3f4f5;
}
</style>