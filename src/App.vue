<script>
import Header_vue from './components/header.vue'
import Nav from './components/nav.vue'
export default {
  components: {
    Header_vue,
    Nav,
  },
  data() {
    return {
      showNav: true // 預設顯示 Nav 組件
    };
  },
  created() {
    // 監聽路由變化，根據路由名稱判斷是否顯示 Nav 組件
    this.$router.beforeEach((to, from, next) => {
      // 檢查路由名稱是否在不顯示 Nav 組件的頁面列表中
      const pagesWithoutNav = ['首頁', '使用規約', '個人隱私權條款', '登入', '註冊', '註冊數位公民', '忘記密碼', '重設密碼']; // 替換為你要不顯示 Nav 組件的頁面路由名稱
      if (pagesWithoutNav.includes(to.name)) {
        this.showNav = false; // 不顯示 Nav 組件
      } else {
        this.showNav = true; // 其他頁面顯示 Nav 組件
      }
      next();
    });
  }
}
</script>

<template>
  <Header_vue />
  <section>
    <div id="page-wrapper">
      <div style="padding-top: 100px;">
        <router-view />
      </div>
    </div>
  </section>
  <Nav v-if="showNav"/>
</template>

<style>
section{
  padding-bottom:85px;
}
</style>