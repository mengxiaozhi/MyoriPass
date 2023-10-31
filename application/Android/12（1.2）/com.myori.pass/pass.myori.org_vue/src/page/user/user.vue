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
    const fetchUserData = () => {
      axios.get('https://pass.myori.org/api/user.php')
        .then(response => {
          if (response.data.success) {
            qrCodeUrl.value = response.data.qrCodeUrl;
            countries.value = response.data.countries;
            displayedName.value = response.data.displayedName;
            greeting.value = response.data.greeting;
            userStore.setStatus(1);
          } else {

            router.push('/');
          }
        })
        .catch(error => {
          console.error('獲取數據時出錯', error);
          userStore.setStatus(0); // 更新用戶狀態
        });
    };
    // qrcode
    const qrCodeImageUrl = computed(() => {
      if (qrCodeUrl.value) {
        return `https://chart.apis.google.com/chart?chs=300x300&cht=qr&chl=${encodeURIComponent(qrCodeUrl.value)}`;
      }
      return '';
    });


    onMounted(fetchUserData);


    return {
      qrCodeUrl,
      countries,
      displayedName,
      greeting,
      qrCodeImageUrl
    };
  },
};
</script>
<template>
  <h1>
    {{ displayedName }} ， {{ greeting }}<br>
    歡迎回來
  </h1>
  <h3 class="title-section">個人識別碼 QR-ID</h3>
  <div style="display:flex;justify-content:center;">
    <img :src="qrCodeImageUrl" alt="QR-ID">
  </div>
  <p style="display:flex;justify-content:center;">國籍：{{ countries }}</p>
</template>