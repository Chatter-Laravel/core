import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.use(Vuex)

import router from './router'
import store from './store'
import App from './views/App'

window.ChatterEvents = new Vue();
const chatter_app = new Vue({
    el: '#chatter_app',
    components: { App },
    router,
    store
});