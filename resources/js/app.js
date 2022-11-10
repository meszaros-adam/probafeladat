import './bootstrap';
import { createApp } from 'vue'
import BootstrapVue3 from "bootstrap-vue-3";
import "bootstrap-vue-3/dist/bootstrap-vue-3.css";
import router from './router'
import App from './app.vue'
import 'bootstrap-icons/font/bootstrap-icons.css'

const app = createApp(App)
app.use(BootstrapVue3)
app.use(router)
app.mount("#app")