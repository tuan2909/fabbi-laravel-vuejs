import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.config.productionTip = false;
//Admin layout
import AdminLayout from './layout/Wrappers/AdminLayout/baseLayout'
// User layout
import UserLayout from './layout/Wrappers/UserLayout/baseLayout'
// Default layout
import DefaultLayout from './layout/Wrappers/defaultLayout'
import "./permission" //permission control

import { ValidationObserver } from "vee-validate";
import { ValidationProvider } from "vee-validate/dist/vee-validate.full.esm";

Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)

Vue.component('user-layout', UserLayout);
Vue.component('default-layout', DefaultLayout);
Vue.component('admin-layout', AdminLayout);
new Vue({
    router,
    store,
    render: (h) => h(App),
}).$mount("#app");
