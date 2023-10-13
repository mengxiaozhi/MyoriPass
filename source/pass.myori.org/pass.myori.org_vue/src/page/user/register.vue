<script>
import axios from 'axios'

export default {
    data() {
        return {
            selectedCountry: '',
            idNumber: '',
            countries: [],
            message: "",
            email: "",
            name: "",
            password: "",
            confirmPassword: ""
        }
    },
    methods: {
        submitForm(event) {
            event.preventDefault();

            if (this.password !== this.confirmPassword) {
                alert("密碼與確認密碼不符，請重新輸入。");
                return;
            }
            // 設定成用formdata
            let formData = new URLSearchParams();
            formData.append('email', this.email);
            formData.append('name', this.name);
            formData.append('countries', this.selectedCountry);
            formData.append('id', this.id);
            formData.append('password', this.password);

            axios.post('/api/register.php', formData)
                .then(response => {
                    // console.log(response.data);
                    this.message = response.data.message;

                    // 如果註冊成功push到user
                    if (response.data.message === "成功") {
                        this.$router.push('/user'); //登入成功push到user.vue
                    }
                })
                .catch(error => {
                    this.message = "提交時發生錯誤";
                    alert(this.message);
                });
        }


    },
    mounted() {
        axios.get('https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json')
            .then(response => {
                this.countries = response.data;
            });
    }
}
</script>

<template>
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

