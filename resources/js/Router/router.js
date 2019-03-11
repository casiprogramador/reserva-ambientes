import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/login/Login';
import Signup from '../components/login/Signup';
import Calendar from '../components/Calendar';
import ListaAmbientes from '../components/ListaAmbientes';
import CrearAmbiente from '../components/CrearAmbiente';
import ListaUsuario from '../components/ListaUsuario';

const routes = [
    { path: '/', component: ListaAmbientes },
    { path: '/login', component: Login },
    { path: '/lista-ambientes', component: ListaAmbientes },
    { path: '/registrar-ambiente', component: CrearAmbiente },
    { path: '/lista-usuarios', component: ListaUsuario },
    { path: '/registrar-usuario', component: Signup },
    { path: '/reserva', component: Calendar },
    
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

export default router