require('./bootstrap');

import VueRouter from 'vue-router';
import router from './routes';
import store from './store';


Vue.use(VueRouter);

Vue.component('App', require('./components/App.vue'));
const app = new Vue({
    el: '#app',
    data:{
        // show_close_router_btn:false,
    },
    router,
    store,
    methods:{
        viewRouter(e){
            let route = e.currentTarget.dataset.route;
            // this.$router.push('/'+route);
            // this.$store.commit('showRouter');
        },
    }
});
