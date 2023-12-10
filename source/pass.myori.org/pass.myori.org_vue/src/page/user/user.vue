<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/store/userStore';

export default {
  setup() {
    // 用戶狀態管理
    const userStore = useUserStore();
    const qrCodeUrl = ref('');
    const countries = ref('');
    const displayedName = ref('');
    const greeting = ref('');
    const router = useRouter();

    // 倒數計時器
    const countdown = ref(30);

    // Function to fetch user data
    const fetchUserData = () => {
      axios.get('/api/user.php')
        .then(response => {
          if (response.data.success) {
            qrCodeUrl.value = response.data.qrCodeUrl;
            countries.value = response.data.countries;
            displayedName.value = response.data.displayedName;
            greeting.value = response.data.greeting;
            userStore.setStatus(1);

            // 重置倒數計時器
            countdown.value = 30;
          } else {
            router.push('/');
          }
        })
        .catch(error => {
          console.error('獲取數據時出錯', error);
          userStore.setStatus(0); // 更新用戶狀態
        });
    };

    // Function to fetch user data every 30 seconds
    const refreshUserData = () => {
      fetchUserData();
    };

    // qrcode
    const qrCodeImageUrl = computed(() => {
      if (qrCodeUrl.value) {
        return `https://chart.apis.google.com/chart?chs=300x300&cht=qr&chl=${encodeURIComponent(qrCodeUrl.value)}`;
      }
      return '';
    });

    // Call fetchUserData on component mount
    onMounted(() => {
      fetchUserData();

      // Refresh user data every 30 seconds
      setInterval(refreshUserData, 30000);

      // Update countdown every second
      setInterval(() => {
        countdown.value = Math.max(countdown.value - 1, 0);
      }, 1000);
    });

    return {
      qrCodeUrl,
      countries,
      displayedName,
      greeting,
      qrCodeImageUrl,
      countdown
    };
  },
};
</script>

<template>
  <div>
    <h1>
      {{ displayedName }} ， {{ greeting }}<br>
      歡迎回來
    </h1>
    <h3 class="title-section">個人識別碼 QR-ID</h3>
    <div style="display:flex;justify-content:center;">
      <img :src="qrCodeImageUrl" alt="QR-ID">
    </div>
    <div style="display:flex;justify-content:center;margin-top:-50px;">
        <p style="color: rgb(255, 255, 255); background-color: rgb(0, 23, 193); min-width: 225px; height: 27px; display: flex; justify-content: center;">{{ countdown }} 秒後刷新</p>
    </div>
    <p style="display:flex;justify-content:center;">國籍：{{ countries }}</p>
    <h3 class="title-section">身分授權紀錄</h3>
    <div class="a_list">
      <h4 style="display: flex; justify-content: center;">無授權/出入國紀錄</h4>
    </div>
  </div>
</template>

<style>
.a_list{
  min-height: 117px;
  border: 1.5px solid #41445040;
  background-color: #4144501c;
  border-radius: 11px;
  padding: 10px;
}
</style>