<script>
import axios from 'axios';
export default{
    data(){
        return{
        selectedCountry: '',
        countries: [] 
        }
    },
    mounted() {
       
        axios.get('https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json')
            .then(response => {

            this.countries = response.data;
        })
        .catch(error => {
            console.error('Error loading countries:', error);
        });
    }
}
</script>
<template>
<h2>管理MyoriPas賬號資料</h2>
<h3 class="title-section">更新帳號基本資料</h3>
<form action="profile" method="post" onsubmit="return validatePassword();">
    <div>
        <label><h3>Email</h3></label>
        <input type="email" name="email" placeholder="Email" maxlength="128" onkeyup="this.value=this.value.replace(/\s+/g,'')" value="{{ email }}" required>
    </div>
    <div>
        <label><h3>姓名</h3></label>
        <input type="text" name="name" placeholder="姓名" pattern=".{2,}$" maxlength="32" onkeyup="this.value=this.value.replace(/\s+/g,'')" value="{{ name }}" required>
    </div>
    <div>
        <label for="options"><h3>國籍</h3></label>
        <select v-model="selectedCountry" name="countries" required>
            <option value="">請選擇國家</option>
            <option v-for="country in countries" :value="country.code">{{ country.name }}</option>
        </select>
    </div>
    <div name="id">
        <label><h3>MyNumber編號/護照號碼</h3></label>
        <div v-if="selectedCountry === 'MAL'">
            <p>・ 國籍為苗栗國或東亞聯邦成員國，根據「苗栗國個人資料管理條例」無法修改證件資料</p>
            <input type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9" disabled="disabled" onkeyup="this.value=this.value.replace(/\s+/g,\'\')" value="{{ id }}">
        </div>
        <input v-else type="text" name="id" placeholder="MyNumber編號/護照號碼" pattern=".{5,}$" maxlength="9" onkeyup="this.value=this.value.replace(/\s+/g,\'\')" value="{{ id }}">
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
    <a href="download_data.php">
        <button class="btn btn-default icn_button">
            <img src="/icn_download.svg" alt="dowload">
            <h3>下載賬號個資</h3>
        </button>
    </a>
</div>
<div class="warning">
        <button class="btn btn-default icn_button" id="delete">
            <img src="/icn_attention.svg" alt="warning">
            <h3>刪除全部資料</h3>
        </button>
</div>
<div id="hidden-window" style="display:none">
    <h2>刪除全部資料</h2>
    <h3 class="title-section">驗證密碼</h3>
            <div>
                <form action="delete.php" method="post">
                    <div style="display:none;">
                        <label><h3>MyNumber編號 或 Email地址</h3></label>
                        <input type="text" name="username" placeholder="MyNumber編號 & Email"  value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div>
                        <label><h3>密碼</h3></label>
                        <input type="password" name="password" placeholder="密碼" required>
                    </div>
                    <div class="warning">
                        <button class="btn btn-default icn_button" id="delete">
                            <img src="/icn_attention.svg" alt="warning">
                            <h3>確認刪除資料</h3>
                        </button>
                    </div>
                </form>
                </div>
            </div>  
</template>