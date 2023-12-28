<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
    setup() {

        const email = ref('');
        const name = ref('');
        const id = ref('');
        const selectedCountry = ref('MAL')
        const password = ref('');
        const confirmPassword = ref('');
        const registrationSuccess = ref(false);
        const message = ref('');
        const countries = ref([]);
        const router = useRouter();


        const submitForm = async (event) => {
            event.preventDefault();

            if (password.value !== confirmPassword.value) {
                message.value = "密碼與確認密碼不符，請重新輸入。";
                return;
            }

            const formData = new URLSearchParams();
            formData.append('email', email.value);
            formData.append('name', name.value);
            formData.append('countries', selectedCountry.value);
            formData.append('password', password.value);

            try {
                const response = await axios.post('/api/digital.php', formData);
                //登入狀態
              
                if (response.data.success === true) { // 檢查註冊成功
                    registrationSuccess.value = true;
                    message.value = response.data;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                
                    message.value = response.data; 
                }
            } catch (error) {
                message.value = "提交時發生錯誤: " + error.toString();
            }
        };
        const letToLogin = () => {
            router.push('/main/login');
        };




        return {
            email,
            name,
            selectedCountry,
            id,
            password,
            confirmPassword,
            registrationSuccess,
            message,
            countries,
            submitForm,
            letToLogin
        };
    },
};
</script>

<template>
    <div v-if="registrationSuccess" @click="letToLogin" class="success-message ">
        <i class="fas fa-check-circle"></i> 註冊成功！<span class="bold-text">點我登入</span>
    </div>

    <h2>注冊成爲苗栗國數位公民</h2>
    <h3 class="title-section">關於使用</h3>
    <p style="display: flex;justify-content: center;">
        提交申請即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。<br>
        *此表單為數字公民身份申請表，並不具備完整的公民權利，我們也不會將您的資料納入我們的國民系統不會给予您My
        Number編號。如果您後續想成爲苗栗國公民，請準備您的身份證明文件進行KYC以及填寫入籍申請表，審核完成後入籍即成爲苗栗國公民。<br>
        *注意，數位公民身份和外國人身份可以同時存在，如果您已經具備了外國人賬號請使用其他Email進行注冊或直接使用原賬號進行身份轉換，Email為數位公民身份的唯一憑證。
    </p>
    <div class='register-form'>
        <h3 class="title-section">輸入帳號資料</h3>
        <form @submit.prevent="submitForm">
            <div>
                <label>
                    <h3>Email</h3>
                </label>
                <input type="email" v-model="email" name="email" placeholder=Email maxlength="128"
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
                <select name="countries" v-model="selectedCountry" required>
                    <option value="MAL">苗栗（數位）</option>
                </select>
            </div>
            <div>
                <label>
                    <h3>密碼</h3>
                </label>
                <p>
                    ・ 10個字元以上<br>
                    ・ 大寫英文+小寫英文+數字+符號的組合<br>
                    ・ 密碼中允許輸入的符號如下+-*/=.,:;`@!#$%?|~^()[]{}_
                </p>
                <input type="password" v-model="password" name="password" placeholder="密碼"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')"
                    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
            </div>
            <div>
                <label>
                    <h3>確認密碼</h3>
                </label>
                <input type="password" v-model="confirmPassword" name="confirm_password" placeholder="確認密碼"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')"
                    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
            </div>
            <div>
                <button type="submit" class="btn btn-default" id="login">
                    <h3>註冊數位公民</h3>
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.success-message {
    border: 2px solid #0017c1;
    background-color: transparent;
    color: #0017c1;
    padding: 10px;
    margin-bottom: 15px;
    cursor: pointer;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-message i {
    margin-right: 6px;
    margin-top: 2px;
    color: #0017c1;
}

.bold-text {
    font-weight: bold;
}
</style>