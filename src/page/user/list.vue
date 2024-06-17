<script>
import { ref, onMounted, computed, onUnmounted, watch } from 'vue';
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
    const sortOrder = ref('desc'); // 新增 sortOrder 變數來控制排序順序

    // 倒數計時器
    const countdown = ref(30);
    let intervalId = null;

    // Axios 拦截器处理错误
    axios.interceptors.response.use(
      response => response,
      error => {
        console.error('獲取數據時出錯', error);
        userStore.setStatus(0); // 更新用戶狀態
        return Promise.reject(error);
      }
    );

    // Function to fetch user data and authorize records
    const fetchData = () => {
      axios.all([
        axios.get('/api/user.php'),
        axios.get('/api/get_authorize.php')
      ])
      .then(axios.spread((userData, authorizeData) => {
        if (userData.data.success) {
          qrCodeUrl.value = userData.data.qrCodeUrl;
          countries.value = userData.data.countries;
          displayedName.value = userData.data.displayedName;
          greeting.value = userData.data.greeting;
          userStore.setStatus(1);
          countdown.value = 30;
        } else {
          router.push('/main/');
        }
        records.value = authorizeData.data.records.sort((a, b) => sortOrder.value === 'desc' ? parseDate(b.timedate) - parseDate(a.timedate) : parseDate(a.timedate) - parseDate(b.timedate));
      }))
      .catch(error => {
        console.error('獲取數據時出錯', error);
        userStore.setStatus(0); // 更新用戶狀態
      });
    };

    // qrcode
    const qrCodeImageUrl = computed(() => {
      if (qrCodeUrl.value) {
        return `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(qrCodeUrl.value)}&size=225x225`;
      }
      return '';
    });

    // 日期格式化函数
    const formatDate = (dateString) => {
      const date = parseDate(dateString);
      return date ? date.toLocaleString() : '无效日期';
    };

    // 解析日期字符串函数
    const parseDate = (dateString) => {
      const year = parseInt(dateString.substring(0, 4), 10);
      const month = parseInt(dateString.substring(4, 6), 10) - 1; // 月份从0开始
      const day = parseInt(dateString.substring(6, 8), 10);
      const hour = parseInt(dateString.substring(8, 10), 10);
      const minute = parseInt(dateString.substring(10, 12), 10);
      const second = parseInt(dateString.substring(12, 14), 10);

      const date = new Date(year, month, day, hour, minute, second);
      return isNaN(date.getTime()) ? null : date;
    };

    // Call fetchData on component mount
    onMounted(() => {
      fetchData();

      // Update countdown every second
      intervalId = setInterval(() => {
        countdown.value = Math.max(countdown.value - 1, 0);
        if (countdown.value === 0) {
          fetchData();
        }
      }, 1000);
    });

    onUnmounted(() => {
      clearInterval(intervalId);
    });

    // 监控排序方式的变化并重新排序
    watch(sortOrder, () => {
      records.value.sort((a, b) => sortOrder.value === 'desc' ? parseDate(b.timedate) - parseDate(a.timedate) : parseDate(a.timedate) - parseDate(b.timedate));
    });

    return {
      qrCodeUrl,
      countries,
      displayedName,
      greeting,
      qrCodeImageUrl,
      countdown,
      records,
      formatDate,
      sortOrder
    };
  },
};
</script>

<template>
  <div class="decoration">
    <h1>
      身分授權紀錄
    </h1>
    <p>
      本列表包含了所有的授權紀錄，例如出入境、電子報稅、身分識別等。
    </p>
  </div>
  <div class="sort-options">
    <select v-model="sortOrder" id="sortOrder">
      <option value="desc">從最近的紀錄排列</option>
      <option value="asc">從最早的紀錄排列</option>
    </select>
  </div>
  <div v-if="records && records.length > 0" class="a_list">
    <div v-for="record in records" :key="record.record_code" class="record_item animate__animated animate__fadeInUp">
      <p>授權編號：{{ record.record_code }}</p>
      <p>授權時間：{{ formatDate(record.timedate) }}</p>
      <p>要授權人：{{ record.user_name }}</p>
      <p>被授權人：{{ record.authorize_name }}</p>
    </div>
  </div>
  <div v-else class="a_list">
    <h4 style="display: flex; justify-content: center;">無授權/出入國紀錄</h4>
  </div>
</template>

<style scoped>
.a_list {
  min-height: 117px;
  border: 1.5px solid #41445040;
  background-color: #4144501c;
  border-radius: 11px;
  padding: 10px;
}
.record_item {
  border-bottom: 1.5px solid #41445040;
}
.decoration p {
  padding-bottom: 30px;
}
.decoration p {
  margin-block-start: 0;
  margin-block-end: 0;
}
.decoration h1 {
  padding-bottom: 10px;
}
.sort-options {
  margin-bottom: 20px;
}
.sort-options label {
  margin-right: 10px;
}
</style>