<template>
    <main>
        <h1 class="visually-hidden">Sidebars examples</h1>

        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-bootstrap-fill me-2 bi-lg" style="font-size: 2rem"></i>
                <span class="fs-4">Dashboard</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <i class="bi bi-house me-2"></i> Page 1
                    </router-link>
                </li>
                <li>
                    <router-link to="/page" class="nav-link text-white">
                        <i class="bi bi-list me-2"></i> Page 2
                    </router-link>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" class="rounded-circle me-2" width="32" height="32">
                    <strong>{{ user.name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a @click.prevent="logout()" class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>

        <router-view></router-view>
    </main>
</template>

<script>
import Api from "@/api.js"

export default {
    computed: {
        user: function () {
            return this.$store.getters.user;
        },
    },
    methods: {
        logout() {
            //Api.logout().then((response) => {
            this.$store.dispatch({
                type: "unauthenticate",
            });

            this.$router.push("/login");
            //});
        },
    },
};
</script>

<style scoped>
main {
    display: flex;
    flex-wrap: nowrap;
    height: 100vh;
    height: -webkit-fill-available;
    max-height: 100vh;
    overflow-x: auto;
    overflow-y: hidden;
}
</style>
