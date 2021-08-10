require('./bootstrap');
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Home from './components/pages/home.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    }
    
]

export default new Router({
    mode: 'history',
    routes
})