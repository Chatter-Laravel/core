import Vue from 'vue'
import Vuex from 'vuex'

import router from './router'
import store from './store'
import App from './views/App'

Vue.use(VueRouter)
Vue.use(Vuex)

window.ChatterEvents = new Vue();
const chatter_app = new Vue({
    el: '#chatter_app',
    components: { App },
    router,
    store
});