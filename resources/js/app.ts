import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'
import '../scss/bootstrap-theme.css'
import '../scss/custom.scss'
import router from '@/router'
import Api from '@/api.js'
import Layout from '@/layouts/Layout.vue'

import axios from 'axios'
(window as any).axios = axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const pinia = createPinia()
const app = createApp(Layout)
    .use(pinia)

import { useAuthStore } from "@/stores/AuthStore.js"
const authStore = useAuthStore()

Api.me()
    .then((response) => {
        if (response.authenticated) {
            authStore.authenticate(response.id, response.name, response.admin)
        }
    })
    .catch((error) => {
        console.log(error)
    })
    .finally(() => {
        app.use(router)
            .mount('#app')
    })


