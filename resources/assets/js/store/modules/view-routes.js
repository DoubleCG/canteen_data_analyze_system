export default {
    state:{
        show_view_router:true,
    },
    mutations:{
        closeRouter (state) {
            state.show_view_router = false;
        },
        showRouter (state){
            state.show_view_router = true;
        }
    }
}
