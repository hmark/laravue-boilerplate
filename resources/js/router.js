import { createRouter, createWebHistory} from 'vue-router'

const routes = [{
    path: "/",
    component: () => import("@/components/Dashboard.vue"),
},{
    path: "/page",
    component: () => import("@/components/Page.vue"),
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
