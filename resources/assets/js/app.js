require('./bootstrap');
window.Vue = require('vue');
window._ = require('lodash');
window.axios = require('axios');
window.$ = window.jQuery = require('jquery');

Vue.component('App', require('./components/App.vue'));
const app = new Vue({
    el: '#app'
});
