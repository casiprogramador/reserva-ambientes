
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import Vuetify from 'vuetify'
import VueScheduler from 'v-calendar-scheduler';
import moment from 'moment'
import 'v-calendar-scheduler/lib/main.css';

Vue.use(Vuetify)
Vue.use(VueScheduler,{locale: 'es',
labels: {
    today: 'Hoy',
    back: 'Atrás',
    next: 'Siguiente',
    month: 'Mes',
    week: 'Semana',
    day: 'Día',
    all_day: 'Todo el día'
 }
})

import User from './Helpers/User'
window.User = User
Vue.prototype.moment = moment
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('AppHome', require('./components/AppHome.vue').default);
import router from './Router/router.js';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
