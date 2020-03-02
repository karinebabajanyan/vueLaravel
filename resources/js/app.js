/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap/js/src/index');
import VueRouter from 'vue-router';
import {router} from "./router";
import welcome from './components/Welcome';
import {Tabs, Tab} from 'vue-tabs-component';
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";


window.Vue = require('vue');


Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

Vue.use(BootstrapVue);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('header-component', require('./components/layouts/Header.vue'));
// Vue.component('footer-component', require('./components/layouts/Footer.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter);
const layoutOne = new Vue({
    el: '#posts',
    router: router,
    render:h=>h(welcome)
});
