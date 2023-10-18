<script>
import axios from 'axios'

export default{
    data() {
        return {
            username: '',
            password: '',
            remember: false,
            status: 0 
        };
    },
    methods: {
        login() {
    //   FormData
        const data = new FormData();
        data.append('username', this.username);
        data.append('password', this.password);
        data.append('remember', this.remember ? '1' : '0');

       
        axios.post('/api/login.php', data)
            .then(response => {
            console.log(response.data);
            this.status = response.data.status;
            console.log(this.status)
            if (this.status === 1) {
                this.$router.push('/user'); // 跳轉到user
                }
            })
            .catch(error => {
            // 處理錯誤
            console.error(error);
          
            if (error.response) {
                console.error(error.response.data);
            }
            });
        }
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
            <label><h3>MyNumber編號 或 Email地址</h3></label>
            <input v-model="username" type="text" name="username" placeholder="MyNumber編號 & Email" required>
        </div>
        <div>
            <label><h3>密碼</h3></label>
            <input v-model="password" type="password" name="password" placeholder="密碼" required>
        </div>
        <div style="display:flex;height: 37px;margin-top: 17px;">
            <input v-model="remember" type="checkbox" name="remember" value="1">
            <label>
                <p style="line-height: 37px;margin-left:10px;margin-block-start: 0;margin-block-end: 0;">保持登入狀態</p>
            </label>
        </div>
        <div class="button">
            <button type="submit" class="btn btn-default" id="login"><h3>登入</h3></button>
        </div>
    </form>
</div>
</template>