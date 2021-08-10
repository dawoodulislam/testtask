require('./bootstrap');

import Vue from 'vue'

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

import router from './router'

Vue.use(ViewUI);

import common from './common'
Vue.mixin(common)

import App from './components/mainapp.vue'

const app = new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
