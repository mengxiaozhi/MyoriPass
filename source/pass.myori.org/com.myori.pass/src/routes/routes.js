import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import { useUserStore } from '@/store/userStore';
const routes = [
  { name: '首頁', path: '/', component: () => import('../page/home.vue') },
  { name: '使用規約', path: '/terms', component: () => import('../page/terms.vue') },
  { name: '個人隱私權條款', path: '/privacy', component: () => import('../page/privacy.vue') },
  { name: '登入', path: '/user/login', component: () => import('../page/user/login.vue') },
  { name: '註冊', path: '/user/register', component: () => import('../page/user/register.vue') },
  { name: '註冊數位公民', path: '/user/digital', component: () => import('../page/user/digital.vue') },
  { name: '用戶首頁', path: '/user', component: () => import('../page/user/user.vue') },
  { name: '用戶管理', path: '/user/profile', component: () => import('../page/user/profile.vue') },
  { name: '更改密碼', path: '/user/password', component: () => import('../page/user/password.vue') },
]

const router = createRouter({
  scrollBehavior(to, from, savedPosition) {
    // 始终滚动到顶部
    return { top: 0 }
  },
  history: createWebHistory(),
  routes,//路由表
  mode: 'history' // history 改为 hash
})
router.beforeEach((to, from, next) => {
  // 在每个页面加载时触发检查用户状态
  axios.get('https://pass.myori.org/api/check_status.php', {
    withCredentials: true 
})
    .then(response => {
      console.log(response)
      const userStore = useUserStore();
      if (response.data.success) {
        userStore.setStatus(1); // 设置用户状态为 1 表示已登录
      } else {
        userStore.setStatus(0); // 设置用户状态为 0 表示未登录
      }
      next();
    })
    .catch(error => {
      console.error('用户状态检查失败', error);
      next();
    });
});
export default router