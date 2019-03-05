import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/login/Login';
import ListaAmbientes from '../components/ListaAmbientes';

const routes = [
    { path: '/login', component: Login },
    { path: '/lista-ambientes', component: ListaAmbientes }
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

export default router