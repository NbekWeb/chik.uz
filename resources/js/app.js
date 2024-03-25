import './bootstrap';
import { createApp } from 'vue';
import App from '../js/App.vue'
import '../css/app.css'
import router from './router'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

createApp(App).use(router).mount('#app')