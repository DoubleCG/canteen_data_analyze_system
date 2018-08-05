import JWTToken from './../../helpers/JWT'

export default {
    actions: {
        loginRequest({dispatch}, formData) {
            return axios.post('/api/login', formData)
                .then(response => {
                    dispatch('loginSuccess',response.data);
                })
                .catch(error => {
                    console.log(error);
                    Message.error('用户名或密码错误，请重试');
                    return 1;
                });
        },
        loginSuccess({dispatch}, tokenResponse) {
            JWTToken.setToken(tokenResponse.token);
            JWTToken.setAuthId(tokenResponse.auth_id);

            dispatch('setAuthUser');

        },
        logoutRequest({dispatch}) {
            return axios.post('/api/logout').then(response => {
                JWTToken.removeToken();
                dispatch('unsetAuthUser')
            })
        }

    },
}
