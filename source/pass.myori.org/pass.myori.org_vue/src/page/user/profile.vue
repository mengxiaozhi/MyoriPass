<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/store/userStore';

const email = ref('');
const name = ref('');
const selectedCountry = ref('');
const id = ref('');
const countries = ref([]);
const isDeleteWindowVisible = ref(false);
const password = ref('')
// 用戶狀態管理
const userStore = useUserStore();
const router = useRouter();


// 載入用戶原本資料
const loadData = async () => {
    try {
        const response = await axios.get('/api/profile_get.php');
        if (response.data.success) {
            email.value = response.data.email;
            name.value = response.data.name;
            selectedCountry.value = response.data.countries;
            id.value = response.data.id;

        } else {
            console.error('無法取得profile');

        }
    } catch (error) {

        console.error('Error loading profile:', error);
    }
};
// 提交修改
const submitForm = async () => {
    const formData = new URLSearchParams();
    formData.append('email', email.value);
    formData.append('name', name.value);
    formData.append('countries', selectedCountry.value);
    formData.append('id', id.value);
    try {
        const response = await axios.post('/api/profile_change.php', formData);
        alert(response.data.message);
    } catch (error) {
        console.error('提交錯誤', error);
    }
};
// 刪除資料顯示
const toggleDeleteWindow = () => {
    isDeleteWindowVisible.value = !isDeleteWindowVisible.value;
};

const deleteAccount = async () => {
    try {
        const formData = new URLSearchParams();
        formData.append('username', email.value);
        formData.append('password', password.value);

        const response = await axios.post('/api/delete.php', formData);

        if (response.data.success == true) {
            alert(response.data.message)
            userStore.clearUser();
            userStore.setStatus(0);
            router.push('/main/');
        } else {
            alert(response.data.message)
        }
    } catch (error) {
        console.error('帳號刪除發生錯誤', error)
    }
};
// 載入國家列表並設置默認值
onMounted(async () => {
    await loadData(); // 先加載用戶數據

    try {
        const response = await axios.get('https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json');
        countries.value = response.data;

        // 如果從用戶資料中獲得了國家資訊，那麼設置它，否則設置為列表中的第一個國家
        if (!selectedCountry.value && countries.value.length > 0) {
            selectedCountry.value = countries.value[0].code; // 這裡假設 code 是國家代碼
        }
    } catch (error) {
        console.error('Error loading countries:', error);
    }
});

</script>
<template>
    <h2>管理MyoriPas賬號資料</h2>
    <h3 class="title-section">更新帳號基本資料</h3>
    <form @submit.prevent="submitForm">
        <div>
            <label>
                <h3>Email</h3>
            </label>
            <input type="email" v-model="email" name="email" placeholder="Email" maxlength="128"
                onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
        </div>
        <div>
            <label>
                <h3>姓名</h3>
            </label>
            <input type="text" v-model="name" name="name" placeholder="姓名" pattern=".{2,}$" maxlength="32"
                onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
        </div>
        <div>
            <label for="options">
                <h3>國籍</h3>
            </label>
            <select v-model="selectedCountry" name="countries" required>
                <option value="">請選擇國家</option>
                <option v-for="(country, index) in countries" :key="index" :value="country.code">{{ country.name }}
                </option>
            </select>
        </div>
        <div name="id">
            <label>
                <h3>MyNumber編號/護照號碼</h3>
            </label>
            <div v-if="selectedCountry === 'MAL'">
                <p>・ 國籍為苗栗國或東亞聯邦成員國，根據「苗栗國個人資料管理條例」無法修改證件資料</p>
                <input type="text" v-model="id" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9"
                    disabled="disabled" onkeyup="this.value=this.value.replace(/\s+/g,\'\')">
            </div>
            <input v-else type="text" v-model="id" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9"
                onkeyup="this.value=this.value.replace(/\s+/g,\'\')">
        </div>
        <div>
            <button type="submit" class="btn btn-default icn_button" id="login">
                <img src="/icn_update.svg" alt="warning">
                <h3>更新帳號資料</h3>
            </button>
        </div>
    </form>
    <h3 class="title-section">個人資料管理</h3>
    <div class="register">
        <a href="/api/download_data.php">
            <button class="btn btn-default icn_button">
                <img src="/icn_download.svg" alt="dowload">
                <h3>下載賬號個資</h3>
            </button>
        </a>
    </div>
    <div class="warning">
        <button class="btn btn-default icn_button" @click="toggleDeleteWindow">
            <img src="/icn_attention.svg" alt="warning">
            <h3>刪除全部資料</h3>
        </button>
    </div>
    <div id="hidden-window" v-show="isDeleteWindowVisible">
        <h2>刪除全部資料</h2>
        <h3 class="title-section">驗證密碼</h3>
        <div>
            <form @submit.prevent="deleteAccount">
                <div>
                    <label>
                        <h3>密碼</h3>
                    </label>
                    <input type="password" v-model="password" placeholder="密碼" required>
                </div>
                <div class="warning">
                    <button type="submit" class="btn btn-default icn_button" id="delete">
                        <img src="/icn_attention.svg" alt="warning">
                        <h3>確認刪除資料</h3>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

