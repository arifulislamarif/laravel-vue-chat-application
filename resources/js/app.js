require('./bootstrap');
window.Vue = require('vue');

Vue.component('main-app', require('./components/MainApp.vue').default);

// Vuex
import StoreApp from './store/index'
import Vuex from 'vuex'
const store = new Vuex.Store(StoreApp);

// filter
import filter from './filter'

const app = new Vue({
    el: "#app",
    store,
    filter
});
