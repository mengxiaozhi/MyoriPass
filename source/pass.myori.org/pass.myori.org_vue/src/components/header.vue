<script setup>
import { ref, onMounted, computed } from 'vue';
import { useUserStore } from '@/store/userStore';
import { useRouter } from 'vue-router';
import info from '@/assets/info.json'; 
import 'animate.css';
import axios from 'axios';


const router = useRouter();
const userStore = useUserStore();
const version = ref('');


const status = computed(() => userStore.status);
const menuVisible = computed({
  get: () => userStore.menuVisible,
  set: (value) => {
    userStore.menuVisible = value;  
  }
});

onMounted(() => {
  if (info && info.version) {
    version.value = info.version;
  } else {
    console.error("版本號錯誤");
  }
});


const toggleMenu = () => {
  menuVisible.value = !menuVisible.value;
};

// 處理用戶登出
const logoutUser = async () => {
  try {
    const response = await axios.get('/api/user/exit.php');
    if (response.data.status === 'success') {
      userStore.clearUser();  // 清空用戶資訊
      menuVisible.value = false;  // 關閉選單
      router.push('/');  // 返回首頁
    } else {
      throw new Error('登出失敗');
    }
  } catch (error) {
    console.error('登出過程中出錯:', error);
  }
};

// 點擊標題時的行為
const handleTitleClick = () => {
  router.push(status.value === 1 ? '/user' : '/');
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
                        <li>
                            <RouterLink to="/user/profile">
                                <p>賬戶資料管理</p>
                            </RouterLink>

                        </li>
                        <li><a href="https://pass.myori.org/user/change_password">
                                <p>更改登入密碼</p>
                            </a></li>
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
                    <li>
                        <RouterLink to="terms">
                            <p>使用規約</p>
                        </RouterLink>
                    </li>
                    <li>
                        <RouterLink to="privacy">
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
</div></template>
