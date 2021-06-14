import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

Vue.config.productionTip = false;
//Admin layout
import AdminLayout from './layout/Wrappers/AdminLayout/baseLayout'
// User layout
import UserLayout from './layout/Wrappers/UserLayout/baseLayout'
// Default layout
import DefaultLayout from './layout/Wrappers/defaultLayout'

Vue.component('user-layout', UserLayout)
Vue.component('default-layout', DefaultLayout)
Vue.component('admin-layout', AdminLayout)
new Vue({
    router,
    store,
    render: (h) => h(App),
}).$mount("#app");
