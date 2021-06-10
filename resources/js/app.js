require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Layout from './pages/Layout'
import store from './store'
import router from './router'
import i18n from './i18n.js';
import Api from "./api.js";

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
            .use(i18n)
            .mount('#app');
    });


