<template>
    <div class="container">
        <div class="routerView" v-show='show_view_router'>
            <i class="icono-cross" @click='closeRouter'></i>
            <router-view ></router-view>
        </div>
        <div class="row justify-content-center">
            <div class="card-body">
                <Home></Home>
            </div>
        </div>
    </div>
</template>

<script>

    import Home from "./pages/Home";
    import {mapState,mapMutations } from 'vuex'
// import Cookie from "js-cookie";

export default {
    mounted() {
        console.log('Component mounted.')
    },
    components:{
        Home,
    },
    computed: {
        ...mapState([
          // 映射 this.count 为 store.state.count
          'show_view_router'
        ]),
    },
    methods:{
        ...mapMutations([
          'closeRouter',
        ]),
    }
}
</script>

<style>
    .routerView{
        position:fixed;
        left:0;
        top:6%;
        width:100%;
        height:90%;
        padding:2%;
        background-color:rgba(255,255,255,0.95);
    }

</style>
