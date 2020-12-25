window.Vue = require('vue');

import App from './views/App.vue'
import VueRouter from "vue-router"
import routes from "./routes";
import store from './store'
import Vuelidate from "vuelidate";
import Toaster from 'v-toaster'
import money from 'v-money'
import filters from './filters'
import 'v-toaster/dist/v-toaster.css'
import '../css/sass/_spectre.scss'

Vue.use(VueRouter)
Vue.use(Vuelidate)
Vue.use(filters)
Vue.use(money, { precision: 2 })
Vue.use(Toaster, { timeout: 5000 })

const router = new VueRouter({ routes })

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});