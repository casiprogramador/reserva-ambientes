import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/login/Login';
import Signup from '../components/login/Signup';
import ListaAmbientes from '../components/ListaAmbientes';


const routes = [
    { path: '/login', component: Login },
    { path: '/lista-ambientes', component: ListaAmbientes },
    { path: '/registrar-usuario', component: Signup }
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

export default router