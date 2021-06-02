require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Dashboard from "./components/Dashboard.vue";

const app = createApp({
    components: {
        Dashboard
    }
});

app.mount("#app");
