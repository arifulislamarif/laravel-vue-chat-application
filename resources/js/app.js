require('./bootstrap');
window.Vue = require('vue');

Vue.component('main-app', require('./components/MainApp.vue').default);

import StoreApp from './store/index'
import Vuex from 'vuex'
const store = new Vuex.Store(StoreApp);

const app = new Vue({
    el: "#app",
    store
});
