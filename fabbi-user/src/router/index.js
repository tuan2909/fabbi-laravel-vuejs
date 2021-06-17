import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: 'home',
        meta: {layout: 'admin'},
        component: () => import('../views/Home'),
    },
    {
        path: "/login",
        name: 'login',
        meta: {layout: 'default'},
        component: () => import('../views/login/index'),
    },

];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;
