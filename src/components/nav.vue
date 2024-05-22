<script>
export default {
  data() {
    return {
      isIphonePWA: false
    };
  },
  created() {
    this.checkIfIphonePWA();
  },
  methods: {
    checkIfIphonePWA() {
      const userAgent = window.navigator.userAgent.toLowerCase();
      const isIos = /iphone|ipad|ipod/.test(userAgent);
      const isInStandaloneMode = ('standalone' in window.navigator) && window.navigator.standalone;

      if (isIos && isInStandaloneMode) {
        this.isIphonePWA = true;
      }
    }
  }
};
</script>

<template>
<div :class="['fixed bottom-0 left-0 right-0 z-50 flex h-16 w-full items-center justify-around bg-white shadow-[0_-2px_4px_rgba(0,0,0,0.05)]', {'h-24 pb-5': isIphonePWA}]">
  <RouterLink to="/main/user" class="flex flex-col items-center justify-center gap-y-0.5">
    <div class="gap-1 pr-5 pl-5 pb-1 pt-1 rounded-full" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/user'}">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="h-6 w-6"
      >
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        <polyline points="9 22 9 12 15 12 15 22"></polyline>
      </svg>
    </div>
    <span class="text-xs gap-1 pr-5 pl-5" :class="{ 'font-bold text-blue-600': $route.path === '/main/user'}">首頁</span>
  </RouterLink>
  <RouterLink to="/main/list" class="flex flex-col items-center justify-center gap-y-0.5">
    <div class="gap-1 pr-5 pl-5 pb-1 pt-1 rounded-full" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/list'}">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="h-6 w-6"
      >
        <line x1="8" x2="21" y1="6" y2="6"></line>
        <line x1="8" x2="21" y1="12" y2="12"></line>
        <line x1="8" x2="21" y1="18" y2="18"></line>
        <line x1="3" x2="3.01" y1="6" y2="6"></line>
        <line x1="3" x2="3.01" y1="12" y2="12"></line>
        <line x1="3" x2="3.01" y1="18" y2="18"></line>
      </svg>
    </div>
    <span class="text-xs gap-1 pr-5 pl-5" :class="{ 'font-bold text-blue-600': $route.path === '/main/list'}">紀錄</span>
</RouterLink>
<RouterLink to="/main/more" class="flex flex-col items-center justify-center gap-y-0.5">
  <div  class="gap-1 pr-5 pl-5 pb-1 pt-1 rounded-full" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/more'}">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="h-6 w-6"
      >
        <path d="M5 12h14"></path>
        <path d="M12 5v14"></path>
      </svg>
  </div>
  <span class="text-xs gap-1 pr-5 pl-5" :class="{ 'font-bold text-blue-600': $route.path === '/main/more'}">更多</span>
  </RouterLink>
</div>
</template>
<style scoped>
@tailwind base;
@tailwind components;
@tailwind utilities;
</style>