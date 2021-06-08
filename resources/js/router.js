import { createRouter, createWebHistory} from 'vue-router'

const routes = [{
    path: "/",
    component: () => import("@/pages/Dashboard.vue"),
},{
    path: "/page",
    component: () => import("@/pages/Page.vue"),
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
