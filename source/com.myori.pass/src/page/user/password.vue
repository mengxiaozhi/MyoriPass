<script>
import axios from 'axios';
import { ref } from 'vue';

export default {
    setup() {

        const form = ref({
            old_password: '',
            new_password: '',
            confirmPassword: '',
        });

        const handleSubmit = async () => {
            if (form.value.new_password !== form.value.confirmPassword) {
                alert('新密碼和確認密碼不匹配!');
                return;
            }

            const formData = new FormData();
            formData.append('old_password', form.value.old_password);
            formData.append('new_password', form.value.new_password);

            try {
                const response = await axios.post('/api/change_password.php', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    alert('密碼修改成功!');
                } else {
                    alert('錯誤: ' + response.data.message);
                }
            } catch (error) {
                console.error('更改密碼發生錯誤', error);
                alert('更新密碼時出現錯誤');
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
        <h3 class="title-section">輸入帳號資料</h3>
        <form @submit.prevent="handleSubmit">
            <div class="old-password">
                <label for="old_password">
                    <h3>舊密碼</h3>
                </label>
                <!-- 从 'old_Password' 改为 'old_password' -->
                <input type="password" v-model="form.old_password" required>
            </div>
            <div class="new-password">
                <label for="new_password">
                    <h3>新密碼</h3>
                </label>
                <p>・ 10個字元以上<br>・ 大寫英文+小寫英文+數字+符號的組合<br>・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_</p>
                <input type="password" v-model="form.new_password" required>
            </div>
            <div class="confirm-password">
                <label for="confirm_password">
                    <h3>確認新密碼</h3>
                </label>
                <input type="password" v-model="form.confirmPassword" required>
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

