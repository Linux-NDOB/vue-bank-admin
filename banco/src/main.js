import { createApp } from 'vue'
import './index.css'
import router from './router/index'
import VueSweetalert2 from 'vue-sweetalert2';
import '../node_modules/sweetalert2/dist/sweetalert2.min.css';
import App from './App.vue'
createApp(App).use(router).use(VueSweetalert2).mount('#app')
