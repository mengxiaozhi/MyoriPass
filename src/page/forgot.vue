<script>
    import { ref } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';

    export default {
        setup() {
            const username = ref('');
            const router = useRouter();

            const forget = async () => {
                // 使用 JSON 数据格式
                const data = {
                    email: username.value
                };

                try {
                    const response = await axios.post('/api/forgot-password', data, {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        withCredentials: true
                    });
                    console.log(response.data);

                    // 如果没有状态码，或者状态码成功（假设成功状态码是 200）
                    if (!response.data || response.status === 200) {
                        alert('驗證碼已發送到您的郵箱，請查收。');
                        router.push('/main/reset');
                    } else {
                        alert('發送郵件失敗，請檢查您的郵箱地址。');
                    }
                } catch (error) {
                    console.error('發送郵件過程中出錯:', error);
                    // 如果服务器返回错误消息，则显示该消息
                    if (error.response && error.response.data) {
                        alert(error.response.data);
                    } else {
                        alert('發送郵件時出錯，請稍後再試。');
                    }
                }
            };

            return {
                username,
                forget
            };
        }
    };
</script>

<template>
    <div>
        <h2>忘記密碼</h2>
        <h3 class="title-section">關於忘記密碼</h3>
        <p style="display: flex;">
            輸入您帳戶所綁定的E-mail，我們將對您的郵箱發送驗證碼用於驗證您的身份
        </p>
        <h3 class="title-section">輸入帳號資料</h3>
        <div>
            <form @submit.prevent="forget">
                <div>
                    <label>
                        <h3>Email地址</h3>
                    </label>
                    <input v-model="username" type="email" name="email" placeholder="Email" required>
                </div>
                <div class="button">
                    <button type="submit" class="btn btn-default" id="login">
                        <h3>送出</h3>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>