/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
console.log("fidadeunmaputadok")
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router"
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import routes from "./routes";
import App from './views/App.vue'
import store from './store'
import Vuelidate from "vuelidate";
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
import '../css/sass/_spectre.scss'
import money from 'v-money'


Vue.use(Toaster, { timeout: 5000 })
Vue.use(VueRouter)
Vue.use(Vuelidate)
Vue.use(money, { precision: 2 })

const router = new VueRouter({ routes })

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});