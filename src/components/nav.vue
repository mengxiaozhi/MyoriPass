<template>
<div class="fixed bottom-0 left-0 right-0 z-50 flex h-16 w-full items-center justify-around bg-white shadow-[0_-2px_4px_rgba(0,0,0,0.05)] dark:bg-gray-900 dark:shadow-[0_-2px_4px_rgba(0,0,0,0.1)]">
  <RouterLink to="/main/user" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/user'}" class="pr-8 pl-8 pt-1 pb-1 rounded-full">
  <a
    class="flex flex-col items-center justify-center"
  >
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
    <span class="text-xs font-medium">首頁</span>
  </a>
  </RouterLink>
  <RouterLink to="/main/list" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/list'}" class="pr-7 pl-7 pt-1 pb-1 rounded-full">
  <a
    class="flex flex-col items-center justify-center"
  > 
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
    <span class="text-xs font-medium">紀錄</span>
  </a>
</RouterLink>
<RouterLink to="/main/more" :class="{ 'text-blue-600 bg-blue-100': $route.path === '/main/more'}" class="pr-8 pl-8 pt-1 pb-1 rounded-full">
  <a
    class="flex flex-col items-center justify-center"
  >
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
    <span class="text-xs font-medium">更多</span>
  </a>
  </RouterLink>
</div>
</template>
<style scoped>
@tailwind base;
@tailwind components;
@tailwind utilities;
</style>