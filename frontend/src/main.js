import './assets/main.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import "bootstrap-icons/font/bootstrap-icons.css";

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

const app = createApp(App);
const apiUrl =  'http://localhost:8080/api';

axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (!apiUrl) {
    console.error('A variável de ambiente VUE_APP_API_URL não foi definida!');
} else {
    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = `${apiUrl}`;
}

app.config.globalProperties.$axios = axios;

app.use(router);

app.mount('#app');
