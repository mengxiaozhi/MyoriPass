import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

const routes = [
  { name: '首頁', path: '/', component: () => import('../page/home.vue') },
  { name: '使用規約', path: '/terms', component: () => import('../page/terms.vue') },
  { name: '個人隱私權條款', path: '/privacy', component: () => import('../page/privacy.vue') },
  { name: '登入', path: '/user/login', component: () => import('../page/user/login.vue') },
  { name: '註冊', path: '/user/register', component: () => import('../page/user/register.vue') },
  { name: '註冊數位公民', path: '/user/digital', component: () => import('../page/user/digital.vue') },
  { name: '用戶首頁', path: '/user', component: () => import('../page/user/user.vue') },
  { name: '用戶管理', path: '/user/profile', component: () => import('../page/user/profile.vue') },
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

  if (to.path === '/user/login') {
    axios.get('/api/check_status.php')
      .then(response => {
        if (response.data.success) {
          next({ path: '/user' });
        } else {
          next();
        }
      })
      .catch(error => {
        console.error('登入狀態錯誤:', error);
        next();
      });
  } else {
    next();
  }
});
export default router