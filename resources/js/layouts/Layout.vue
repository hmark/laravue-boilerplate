<template>
    <template v-if="!authStore.isLoggedIn">
        <router-view></router-view>
    </template>
    <template v-else>
        <main>
            <aside class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <i class="bi bi-bootstrap-fill me-2 bi-lg" style="font-size: 2rem"></i>
                    <span class="fs-4">Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">
                            <i class="bi bi-house me-2"></i> Page 1
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/page2" class="nav-link text-white">
                            <i class="bi bi-list me-2"></i> Page 2
                        </router-link>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="https://github.com/hmark.png" alt="" class="rounded-circle me-2" width="32" height="32">
                        <strong>{{ authStore.user.name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a @click.prevent="logout()" class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </aside>

            <router-view></router-view>
        </main>
    </template>
</template>

<script setup lang="ts">
import Api from '@/api'
import { useAuthStore } from '@/stores/AuthStore'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

function logout() {
    Api.logout().then((response) => {
        authStore.unauthenticate()
        router.push("/login")
    });
}
</script>

<style scoped>
aside {
    position: fixed;
    width: 280px;
    height: 100vh;
}

main {
    display: flex;
}
</style>
