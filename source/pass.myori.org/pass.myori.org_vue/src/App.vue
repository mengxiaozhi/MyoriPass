<script>
import { onMounted } from 'vue';
import axios from 'axios';
import { useUserStore } from '@/store/userStore';
import Header_vue from './components/header.vue';
import Home from './page/home.vue';

export default {
  components: {
    Header_vue,
    Home,
  },
  setup() {
    const userStore = useUserStore();

    onMounted(async () => {
      try {
    
        const response = await axios.get('/api/check_status.php');
        if (response && response.data) {
          // 更新用戶狀態
          userStore.setStatus(response.data.status);
        } else {
          throw new Error('無法獲取用戶狀態');
        }
      } catch (error) {
        console.error('檢查用戶狀態時出錯:', error);
      }
    });

  }
}
</script>

<template>
    <header_vue/>
    <section>
        <div style="padding-top: 100px;">
            <transition name="fade" mode="out-in">
              <router-view></router-view>
            </transition>
        </div>
    </section>
</template>

<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>