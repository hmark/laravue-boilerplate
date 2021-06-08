require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Layout from './components/Layout'
import router from './router'
import i18n from './i18n.js';

createApp(Layout)
    .use(router)
    .use(i18n)
    .mount('#app');
