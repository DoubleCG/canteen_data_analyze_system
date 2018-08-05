import JWTToken from './../../helpers/JWT'

export default {
    actions:{
        logoutRequest({dispatch}){
            dispatch('setAuthUserLogout');
        }

    },
}
