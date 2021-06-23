import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        meta: { layout: 'admin' },
        component: () => import('../views/Home'),
    },
    {
        path: '/cities',
        name: 'city',
        meta: { layout: 'admin' },
        component: () => import('../views/city/index')
    },
    {
        path: '/cities/create',
        name: 'create_city',
        meta: { layout: 'admin' },
        component: () => import('../views/city/create')
    },
    {
        path: '/cities/:id',
        name: 'city_edit',
        meta: { layout: 'admin' },
        component: () => import('../views/city/edit')
    },
    {
        path: '/type_patients',
        name: 'type_patients',
        meta: { layout: 'admin' },
        component: () => import('../views/type_patient/index')
    },
    {
        path: "/login",
        name: 'login',
        meta: { layout: 'default' },
        component: () => import('../views/login/index'),
    },

];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;
