require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Layout from './pages/Layout'
import store from './store'
import router from './router'
import i18n from './i18n.js';

createApp(Layout)
    .use(store)
    .use(router)
    .use(i18n)
    .mount('#app');
