<script>
import axios from 'axios'

export default{
    data() {
        return {
            qrContent:'',
            countries:'',
            displayedName:'',
            greeting:''
        };
    },
    methods: {
        user() {
        // 發送 GET 請求到 PHP 後端
        axios.get('/api/user.php', data)
            .then(response => {
            this.qrContent = response.data.qrContent;
            this.countries = response.data.countries;
            this.displayedName = response.data.displayedName;
            this.greeting = response.data.greeting;
            })
            .catch(error => {
            // 處理錯誤
            console.error(error);
            // 如果有 response，则打印 response.data，以便查看后端返回的具体错误信息
            if (error.response) {
                console.error(error.response.data);
            }
            });
        }
    }
}
</script>

<template>
    <h1>
        {{displayedName}} ， {{$greeting}}<br>
        歡迎回來
    </h1>
    <h3 class="title-section">個人識別碼 QR-ID</h3>
    <div style="display:flex;justify-content:center;">
        <img :src="'https://chart.apis.google.com/chart?chs=300x300&cht=qr&chl=' + qrContent" alt="QR-ID">
    </div>
    <p style="display:flex;justify-content:center;">國籍：{{ countries }}</p>
</template>