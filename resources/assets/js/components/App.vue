<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="card-body">
                <Home></Home>
            </div>
        </div>
    </div>
</template>

<script>

import Home from "./pages/Home";
// import Cookie from "js-cookie";

    export default {
        mounted() {
            console.log('Component mounted.')
            // console.log(Cookie.get());
            // console.log(Cookie.remove('XSRF-TOKEN'));

        },
        components:{
            Home,
        }
    }
</script>
