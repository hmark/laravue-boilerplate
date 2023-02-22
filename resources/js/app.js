import { createApp } from "vue";
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'
import '../scss/bootstrap-darkly-theme.css'
import '../scss/custom.scss';
import store from '@/store'
import router from '@/router'
import Api from "@/api.js"
import Layout from '@/pages/Layout.vue'

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Api.me()
    .then((response) => {
        if (response.authenticated) {
            store.dispatch({
                type: "authenticate",
                name: response.name,
            });
        }
    })
    .catch((error) => {
        console.log(error)
    })
    .finally(() => {
        createApp(Layout)
            .use(store)
            .use(router)
            .mount('#app');
    });


