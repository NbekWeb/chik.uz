import './bootstrap';
import { createApp } from 'vue';
import App from '../js/App.vue'
import '../css/app.css'
import router from './router'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

// createApp(App).use(router).mount('#app')



// import "./assets/css/app.css";

// import "bootstrap";
// import "bootstrap/dist/css/bootstrap.css";
import "ant-design-vue/dist/reset.css";
import Antd from "ant-design-vue";
import PrimeVue from 'primevue/config';
// import { createApp } from "vue";
import { createPinia } from "pinia";
import 'primevue/resources/themes/aura-light-green/theme.css'
// import App from "./App.vue";
// import router from "./router";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(PrimeVue)
app.use(Antd);

app.mount("#app");
