<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
    setup() {

        const email = ref('');
        const name = ref('');
        const selectedCountry = ref('');
        const id = ref('');
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
            formData.append('id', id.value);
            formData.append('password', password.value);

            try {
                const response = await axios.post('/api/register.php', formData);
                //登入狀態
                console.log(response.data)
                if (response.data.success === true) { // 檢查註冊成功
                    registrationSuccess.value = true;
                    message.value = response.data;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                alert(response.data.success)
                    message.value = response.data; 
                }
            } catch (error) {
                message.value = "提交時發生錯誤: " + error.toString();
            }
        };

        // 獲取國家數據
        const fetchCountries = async () => {
            try {
                const response = await axios.get('https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json');
                countries.value = response.data;
            } catch (error) {
                console.error("獲取國家數據時出錯:", error);
            }
        };
        const letToLogin = () => {
            router.push('/user/login'); 
        };

        fetchCountries();

       
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

    <h2>注冊MyoriPass</h2>
    <div>
        <h3 class="title-section">關於使用</h3>
        <p style="display: flex;justify-content: center;">
            提交申請即表示您同意將資料交給苗栗國政府進行資料處理，苗栗國政府將依照GDPR（一般資料處理原則）搜集並保存您的資料。
            如果您的國籍不屬於苗栗國或東亞聯邦成員國，您注冊時將不需要填寫證件碼。
        </p>


        <h3 class="title-section">輸入帳號資料</h3>
        <form @submit="submitForm">
            <div>
                <label>
                    <h3>Email</h3>
                </label>
                <input v-model="email" type="email" name="email" placeholder="Email" maxlength="128"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label>
                    <h3>姓名</h3>
                </label>
                <input v-model="name" type="text" name="" placeholder="姓名" pattern=".{2,}$" maxlength="32"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')" required>
            </div>
            <div>
                <label for="options">
                    <h3>國籍</h3>
                </label>
                <select v-model="selectedCountry" name="countries" required>
                    <option value="">請選擇國家</option>
                    <option v-for="country in countries" :value="country.code">{{ country.name }}</option>
                </select>
            </div>
            <div v-if="selectedCountry === 'MAL'" name="id">
                <label>
                    <h3>MyNumber編號/護照號碼</h3>
                </label>
                <input v-model="id" type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')">

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
                <input v-model="password" type="password" name="password" placeholder="密碼"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')"
                    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>

            </div>
            <div>
                <label>
                    <h3>確認密碼</h3>
                </label>
                <input v-model="confirmPassword" type="password" name="confirm_password" placeholder="確認密碼"
                    onkeyup="this.value=this.value.replace(/\s+/g,'')"
                    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{10,}$" required>
            </div>
            <div>
                <button type="submit" class="btn btn-default" id="login">
                    <h3>註冊新帳號</h3>
                </button>
            </div>
        </form>
        <div class="register">
            <RouterLink to="digital">
                <button class="btn btn-default">
                    <h3>註冊成爲數位公民</h3>
                </button>
            </RouterLink>
        </div>
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