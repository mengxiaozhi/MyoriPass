import { createApp } from 'vue'
import { createPinia } from 'pinia'  // 导入 createPinia
import './style.css'
import App from './App.vue'
import routes from './routes/routes.js'
import 'fontawesome-free/css/all.css'


const app = createApp(App)

const pinia = createPinia()


app.use(routes)
app.use(pinia)


app.mount("#app")
