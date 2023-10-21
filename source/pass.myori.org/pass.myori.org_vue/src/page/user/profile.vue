<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    // 創建反應式變量
    const email = ref('');
    const name = ref('');
    const selectedCountry = ref('');
    const id = ref('');
    const countries = ref([]);
    const isDeleteWindowVisible = ref(false); // 控制刪除窗口的顯示

    // 加載個人資料數據
    const loadData = async () => {
      try {
        const response = await axios.get('/api/profile.php');
        if (response.data.success) {
          email.value = response.data.email;
          name.value = response.data.name;
          selectedCountry.value = response.data.country; // 這裡應該是單數形式
          id.value = response.data.id;
        } else {
          console.error('無法獲取個人資料');
        }
      } catch (error) {
        console.error('加載數據時出錯', error);
      }
    };

    // 提交表單
    const submitForm = async () => {
      let formData = new URLSearchParams();
      formData.append('email', email.value);
      formData.append('name', name.value);
      formData.append('country', selectedCountry.value); // 這裡應該是單數形式
      formData.append('id', id.value);

      try {
        const response = await axios.post('/api/profile.php', formData);
        if (response.data.success) {
          alert('資料更新成功');
        } else {
          console.error('數據提交失敗');
        }
      } catch (error) {
        console.error('提交表單時出錯', error);
      }
    };

    // 加載國家數據
    const loadCountries = async () => {
      try {
        const response = await axios.get('https://raw.githubusercontent.com/mengxiaozhi/country_code/main/code.json');
        countries.value = response.data;
      } catch (error) {
        console.error('加載國家數據時出錯:', error);
      }
    };

    // 在組件掛載後執行
    onMounted(() => {
      loadData();
      loadCountries();
    });

    // 返回值以使它們在模板中可用
    return {
      email,
      name,
      selectedCountry,
      id,
      countries,
      isDeleteWindowVisible,
      submitForm,
    };
  },
};
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
                <option v-for="country in countries" :value="country.code">{{ country.name }}</option>
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
        <button class="btn btn-default icn_button" id="delete">
            <img src="/icn_attention.svg" alt="warning">
            <h3>刪除全部資料</h3>
        </button>
    </div>
    <div id="hidden-window" style="display:">
        <h2>刪除全部資料</h2>
        <h3 class="title-section">驗證密碼</h3>
        <div>
            <form action="delete.php" method="post">
                <div style="display:none;">
                    <label>
                        <h3>MyNumber編號 或 Email地址</h3>
                    </label>
                    <input type="text" name="username" placeholder="MyNumber編號 & Email"
                        value="<?php echo $user['email']; ?>" required>
                </div>
                <div>
                    <label>
                        <h3>密碼</h3>
                    </label>
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