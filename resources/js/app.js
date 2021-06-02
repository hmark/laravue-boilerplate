require('./bootstrap');

import "bootstrap";
import { createApp } from "vue";
import Home from "./components/Home.vue";

const app = createApp({
    components: {
      Home
    }
});

app.mount("#app");
