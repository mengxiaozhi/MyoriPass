import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import routes from './routes/routes.js'
import axios from 'axios'
import VueAxios from 'vue-axios'

createApp(App).use(routes).mount("#app")