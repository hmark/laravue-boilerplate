require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Layout from './components/Layout'
import router from './router'

createApp(Layout).use(router).mount('#app');
