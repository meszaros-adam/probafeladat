import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import BootstrapVue3 from "bootstrap-vue-3";
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import "bootstrap-vue-3/dist/bootstrap-vue-3.css";
import router from './router'
import App from './app.vue'
import 'bootstrap-icons/font/bootstrap-icons.css'

const app = createApp()
app.component('app', App)
app.use(BootstrapVue3)
app.use(router)
app.mount("#app")