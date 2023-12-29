<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  setup() {
    const router = useRouter(); 
    const status = ref(0); 

 
    onMounted(() => {
      axios.get('https://pass.myori.org/api/check_status.php')
        .then(response => {
          status.value = response.data.status;
          if (status.value === 1) {
            router.push('/user'); // 如果用戶已登錄，則導航到用戶頁面
          }
        })
        .catch(error => {
          console.error('檢查狀態時出錯', error);
        });
    });

  
    return {
      status
    };
  }
};
</script>

<template>
        <h1>MyoriPass<br>
            苗栗通
        </h1>
        <div style="display: flex; justify-content: center; margin-bottom:37px;margin-top:37px">
            <img src="/m_12_white.png" alt="logo" style="width: 100%;">
        </div>
        <div>
            <div class="button">
                <RouterLink to="/user/login">
                    <button class="btn btn-default" id="login"><h3>登入現有賬號</h3></button>
                </RouterLink>
            </div>
            <div class="register">
                <RouterLink to="/user/register">
                    <button class="btn btn-default"><h3>註冊新的帳號</h3></button>
                </RouterLink>
            </div>
        </div>
        <div style="display: flex; justify-content: center;">
            <p>
            使用前請閲讀
            <RouterLink to="terms">使用規約</RouterLink> 及 <RouterLink to="privacy">個人隱私權條款</RouterLink>
            </p>
        </div>
</template>