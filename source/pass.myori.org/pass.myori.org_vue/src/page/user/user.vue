<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

export default {
  setup() {

    const qrCodeUrl = ref('');
    const countries = ref('');
    const displayedName = ref('');
    const greeting = ref('');

    const fetchUserData = () => {
      axios.get('/api/user.php')
        .then(response => {
          if (response.data.success) {
            qrCodeUrl.value = response.data.qrCodeUrl;
            countries.value = response.data.countries;
            displayedName.value = response.data.displayedName;
            greeting.value = response.data.greeting;
          } else {
            console.error('後端未返回成功響應');
          }
        })
        .catch(error => {
          console.error('獲取數據時出錯', error);
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
  
