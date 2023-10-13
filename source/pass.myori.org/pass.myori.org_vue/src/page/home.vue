<script>            
    import axios from 'axios'

    export default {
    data() {
        return {
        status: 0 //初始管理界面为隐藏
        };
    },
    mounted() {
    // 在组件加载后，检查用户登录状态
    this.check_status();
    },
    methods: {
        check_status(){
            axios.get('/api/check_status.php').then(response => {
                this.status = response.data.status;
                if (this.status === 1) {// 数据返回值为1时自动跳转到其他页面
                    router.push('/user'); // 使用路由跳转
                }
            });
        }
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