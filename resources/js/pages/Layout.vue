<template>
    <Auth v-if="!isLoggedIn" />
    <Dashboard v-else />
</template>

<script>
import Auth from "@/pages/Auth.vue"
import Dashboard from "@/pages/Dashboard.vue"

export default {
    components: { Auth, Dashboard },
};
</script>
