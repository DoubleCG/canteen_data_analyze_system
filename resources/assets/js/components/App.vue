<template>
    <div class="container">
        <div class="routerView" v-show='show_view_router'>
            <div class='close-btn' @click='closeRouter'>
                <i class="icono-cross" ></i>
            </div>
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
    .close-btn {
        border-radius: 50%;
        border:2px solid #333;
        position: absolute;
        left:10px;
        top:10px;
        cursor:pointer;
    }

    .routerView{
        overflow-y:scroll;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        padding:2%;
        background-color:rgba(255,255,255,0.95);
    }

</style>
