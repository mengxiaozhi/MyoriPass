import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import { useUserStore } from '@/store/userStore';
const routes = [
  { name: '首頁', path: '/main', component: () => import('../page/home.vue') },
  { name: '使用規約', path: '/main/terms', component: () => import('../page/terms.vue') },
  { name: '個人隱私權條款', path: '/main/privacy', component: () => import('../page/privacy.vue') },
  { name: '登入', path: '/main/login', component: () => import('../page/user/login.vue') },
  { name: '註冊', path: '/main/register', component: () => import('../page/user/register.vue') },
  { name: '註冊數位公民', path: '/main/digital', component: () => import('../page/user/digital.vue') },
  { name: '用戶首頁', path: '/main/user', component: () => import('../page/user/user.vue') },
  { name: '用戶管理', path: '/main/profile', component: () => import('../page/user/profile.vue') },
  { name: '更改密碼', path: '/main/password', component: () => import('../page/user/password.vue') },
  { name: '主動授權', path: '/main/reader', component: () => import('../page/user/reader.vue') },
  { name: 'NotFound', path: '/main/404', component: () => import('../page/404.vue') },
  { path: '/:pathMatch(.*)*', redirect: '/main/404' } 
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
  axios.get('/api/check_status.php',)
    .then(response => {
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