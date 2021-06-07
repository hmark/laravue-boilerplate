import { createRouter, createWebHistory} from 'vue-router'

const routes = [{
    path: "/",
    component: () => import("@/components/Dashboard.vue"),
},{
    path: "/orders",
    component: () => import("@/components/Orders.vue"),
},{
    path: "/:catchAll(.*)",
    redirect: "/",
}];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkExactActiveClass: 'active',
});

export default router;
