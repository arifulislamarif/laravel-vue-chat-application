require('./bootstrap');
window.Vue = require('vue');

// Vuex
import StoreApp from './store/index'
import Vuex from 'vuex'
const store = new Vuex.Store(StoreApp);

// filter
import filter from './filter'

// vue chatscroll
import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll);

Vue.component("main-app", require("./components/MainApp.vue").default);

const app = new Vue({
    el: "#app",
    store,
    filter
});
