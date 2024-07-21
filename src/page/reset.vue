<script>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const router = useRouter();
        const form = ref({
            reset_code: '',
            new_password: '',
            confirmPassword: '',
        });

        const handleSubmit = async () => {
            if (form.value.new_password !== form.value.confirmPassword) {
                alert('新密碼和確認密碼不匹配!');
                return;
            }

            try {
                const response = await axios.post('/api/reset-password', {
                    reset_code: form.value.reset_code,
                    new_password: form.value.new_password
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 200) {
                    alert('密碼修改成功!');
                    router.push('/main/login');
                } else {
                    alert('錯誤: ' + response.data.message);
                }
            } catch (error) {
                console.error('更改密碼發生錯誤', error);
                if (error.response && error.response.data) {
                    alert('更新密碼時出現錯誤: ' + error.response.data);
                } else {
                    alert('更新密碼時出現未知錯誤');
                }
            }
        };

        return {
            form,
            handleSubmit
        };
    }
}
</script>

<template>
    <div>
        <h2>修改MyoriPas登入密碼</h2>
        <form @submit.prevent="handleSubmit">
            <div class="reset_code">
                <label>
                    <h3>驗證代碼</h3>
                </label>
                <input type="text" v-model="form.reset_code" required>
            </div>
            <div class="new-password">
                <label for="new_password">
                    <h3>新密碼</h3>
                </label>
                <p>・ 10個字元以上<br>・ 大寫英文+小寫英文+數字+符號的組合<br>・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_</p>
                <input
                type="password"
                v-model="form.new_password"
                placeholder="密碼"
                onkeyup="this.value=this.value.replace(/\s+/g,'')"
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" 
                required>
            </div>
            <div class="confirm-password">
                <label for="confirm_password">
                    <h3>確認新密碼</h3>
                </label>
                <input
                type="password"
                v-model="form.confirmPassword"
                placeholder="確認新密碼"
                onkeyup="this.value=this.value.replace(/\s+/g,'')"
                pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$"
                required>
            </div>
            <div>
                <button type="submit" class="btn btn-default icn_button" id="login">
                    <img src="/icn_update.svg" alt="warning">
                    <h3>更新登入密碼</h3>
                </button>
            </div>
        </form>
    </div>
</template>