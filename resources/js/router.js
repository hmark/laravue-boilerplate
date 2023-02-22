import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store'

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
        component: () => import("@/pages/Dashboard.vue"),
        meta: {
            requiresAuth: true
        },
        children: [{
            path: "/dashboard",
            component: () => import("@/pages/Page1.vue"),
            meta: {
                requiresAuth: true
            },
        }, {
            path: "/page",
            component: () => import("@/pages/Page2.vue"),
            meta: {
                requiresAuth: true
            },
        }],
        redirect: "/dashboard",
    }, {
        path: "/:catchAll(.*)",
        redirect: "/",
    }];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.getters.isLoggedIn) {
        next({
            path: "/login",
        });
    } else if (!to.meta.requiresAuth && store.getters.isLoggedIn) {
        next({
            path: "/dashboard",
        });
    }
    else {
        next()
    }
});

export default router;
