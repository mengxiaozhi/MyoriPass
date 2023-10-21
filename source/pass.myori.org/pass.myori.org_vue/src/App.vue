<template>
  <Header_vue/>
  <section>
      <div style="padding-top: 100px;">
          <transition name="fade" mode="out-in">
            <router-view></router-view>
          </transition>
      </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/userStore';
import Header_vue from '@/components/Header.vue'; 


const userStore = useUserStore(); 

onMounted(async () => {
  try {
    // 發起 API 請求來檢查用戶狀態
    const response = await axios.get('/api/check_status.php');
    if (response && response.data) {
      userStore.setStatus(response.data.status); 
    } else {
      throw new Error('無法獲取用戶狀態');
    }
  } catch (error) {
    console.error('檢查用戶狀態時出錯:', error);
  }
});
</script>

<style>
/* 轉場效果 */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}
.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
