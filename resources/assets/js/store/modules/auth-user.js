import * as types from './../mutation-type'

export default {
    state: {
        authenticated: false,
        name: null,
        email: null,
        device: null
    },
    mutations: {
        [types.SET_AUTH_USER](state, payload) {
            state.authenticated = true;
            state.name = payload.user.name;
            state.email = payload.user.email;
            state.device = payload.user.device;

        },
        [types.UNSET_AUTH_USER](state) {
            state.authenticated = false;
            state.name = null;
            state.email = null;
            state.device = null;

        },
    },
    actions: {
        setAuthUser({commit, dispatch}) {
            return axios.get('/api/user').then(response => {
                commit({
                    type: types.SET_AUTH_USER,
                    user: response.data
                })
            }).catch(error => {
                dispatch('refreshToken');
            });
        },
        unsetAuthUser({commit}) {
            return commit({
                type: types.UNSET_AUTH_USER,
            })

        },
        refreshToken({commit, dispatch}) {
            return axios.post('/api/token/refresh').then(response => {
                dispatch('loginSuccess', response.data);
            }).catch(error => {
                dispatch('logoutRequest');
            });
        },

    }
}