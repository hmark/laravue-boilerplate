import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/AuthStore.js'

const routes = [
    {
        path: "/login",
        component: () => import("@/pages/Login.vue"),
        meta: {
            requiresAuth: false
        }
    }, {
        path: "/register",
        component: () => import("@/pages/Register.vue"),
        meta: {
            requiresAuth: false
        }
    }, {
        path: "/",
        component: () => import("@/pages/Page1.vue"),
        meta: {
            requiresAuth: true
        },
    }, {
        path: "/page2",
        component: () => import("@/pages/Page2.vue"),
        meta: {
            requiresAuth: true
        },
    }, {
        path: "/:catchAll(.*)",
        redirect: "/",
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()

    if (to.meta.requiresAuth && !authStore.isLoggedIn) {
        next({
            path: "/login",
        });
    } else if (!to.meta.requiresAuth && authStore.isLoggedIn) {
        next({
            path: "/",
        });
    }
    else {
        next()
    }
})

export default router
