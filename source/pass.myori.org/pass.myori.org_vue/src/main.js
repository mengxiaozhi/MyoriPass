import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import routes from './routes/routes.js'
import 'fontawesome-free/css/all.css'

createApp(App).use(routes).mount("#app")