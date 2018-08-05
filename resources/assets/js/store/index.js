import Vue from 'vue'
import Vuex from 'vuex'

import AuthUser from './modules/auth-user'
import Login from './modules/login'
// import viewRoutes from './modules/view-routes'




import stateViewRoutes from './states/view-routes'


import mutationViewRoutes from './mutations/view-routes'



Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        AuthUser,
        Login,
        // viewRoutes
    },
    // state:Object.assign(stateViewRoutes, {}),
    state:{
        show_view_router:false,
    },
    mutations:Object.assign(mutationViewRoutes, {})
})
