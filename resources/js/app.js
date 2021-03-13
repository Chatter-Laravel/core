import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.use(Vuex)

import router from './router'
import store from './store'
import App from './views/App'
import Lang from 'lang.js';

const default_locale = window.default_chatter_locale;
const fallback_locale = window.fallback_chatter_locale;
const messages = window.chatter_messages;

Vue.prototype.chatterTrans = new Lang( { messages: messages, locale: default_locale, fallback: fallback_locale } );

window.ChatterEvents = new Vue();
const chatter_app = new Vue({
    el: '#chatter_app',
    components: { App },
    router,
    store
});