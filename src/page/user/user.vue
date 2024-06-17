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
    const records = ref([]); // 新增 records 變數來存儲授權紀錄

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
            router.push('/main/');
          }
        })
        .catch(error => {
          console.error('獲取數據時出錯', error);
          userStore.setStatus(0); // 更新用戶狀態
        });
    };

    const fetchAuthorizeRecords = () => {
      axios.get('/api/get_authorize.php')
        .then(response => {
          // 将授权记录按时间由大到小排序
          records.value = response.data.records.sort((a, b) => { // 將授權紀錄存入 records
            return new Date(b.timedate) - new Date(a.timedate); // 将时间字符串转换为时间戳，然后比较
          });
        })
        .catch(error => {
          console.error('獲取授權紀錄時出錯', error);
        });
    };

    // Function to fetch user data every 30 seconds
    const refreshUserData = () => {
      fetchUserData();
      fetchAuthorizeRecords();
    };

    // qrcode
    const qrCodeImageUrl = computed(() => {
      if (qrCodeUrl.value) {
        return `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(qrCodeUrl.value)}&size=225x225`;
      }
      return '';
    });

    // Call fetchUserData on component mount
    onMounted(() => {
      fetchUserData();
      fetchAuthorizeRecords();

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
      countdown,
      records
    };
  },
};
</script>

<template>
  <div>
    <h1 class="animate__animated animate__fadeInUp">
      {{ displayedName }} ， {{ greeting }}<br>
      <span class="animate__animated animate__fadeInUp animate__delay-1s">歡迎回來</span>
    </h1>
    <h3 class="title-section">個人識別碼 QR-ID</h3>
    <div style="display:flex;justify-content:center;">
      <img :src="qrCodeImageUrl" alt="QR-ID">
    </div>
    <div style="display:flex;justify-content:center;margin-top:-10px;">
        <p style="color: rgb(255, 255, 255); background-color: rgb(0, 23, 193); min-width: 225px; height: 27px; display: flex; justify-content: center;">{{ countdown }} 秒後刷新</p>
    </div>
    <p style="display:flex;justify-content:center;">國籍：{{ countries }}</p>
  </div>
</template>