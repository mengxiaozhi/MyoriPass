<script>
import { ref } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/userStore';
import { useRouter } from 'vue-router';

export default {
    setup() {
        // 使用 ref 創建響應式引用
        const username = ref('');
        const password = ref('');
        const remember = ref(false);

        const router = useRouter();
        const userStore = useUserStore();

        // 登錄方法
        const login = async () => {
            // 使用 FormData 
            const data = new FormData();
            data.append('username', username.value);
            data.append('password', password.value);
            data.append('remember', remember.value ? '1' : '0');

            try {
                const response = await axios.post('/api/login.php', data, {
                    withCredentials: true 
                });
                console.log(response.data);

                if (response.data.status === 1) {
                    userStore.setStatus(1); // 更新登入狀態1

                    // 導航到用戶頁面
                    router.push('/user');
                } else {
                    alert('登入失敗，請檢查用戶名和密碼。');
                }
            } catch (error) {
                console.error('登錄過程中出錯:', error);
            }
        };

        return {
            username,
            password,
            remember,
            login
        };
    }
};
</script>


<template>
    <h2>登入MyoriPass</h2>
    <h3 class="title-section">關於使用</h3>
    <p style="display: flex;justify-content: center;">
        提交登入即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。<br>
    </p>
    <h3 class="title-section">輸入帳號資料</h3>
    <div>
        <form @submit.prevent="login">
            <div>
                <label>
                    <h3>MyNumber編號 或 Email地址</h3>
                </label>
                <input v-model="username" type="text" name="username" placeholder="MyNumber編號 & Email" required>
            </div>
            <div>
                <label>
                    <h3>密碼</h3>
                </label>
                <input v-model="password" type="password" name="password" placeholder="密碼" required>
            </div>
            <div style="display:flex;height: 37px;margin-top: 17px;">
                <input v-model="remember" type="checkbox" name="remember" value="1">
                <label>
                    <p style="line-height: 37px;margin-left:10px;margin-block-start: 0;margin-block-end: 0;">保持登入狀態</p>
                </label>
            </div>
            <div class="button">
                <button type="submit" class="btn btn-default" id="login">
                    <h3>登入</h3>
                </button>
            </div>
        </form>
    </div>
</template>