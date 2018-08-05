<template>
    <div>
<!--     <button @click='testClick'>testClick</button>
    <router-view></router-view> -->
        <div>
            <div class="news">
                <news></news>
            </div>
            <div class="popular">
                <!-- <popular></popular> -->
            </div>
        </div>
        <div class="dataShow">
            <data-show></data-show>
        </div>
        <div v-show="false" @click="gotop" class="page-component-up">
            <i @click="gotop" class="icono-caretUp"></i>
        </div>

    </div>
</template>

<script>

    import News from '../home/News';
    import Popular from '../home/Popular';
    import DataShow from '../home/DataShow';
    import {mapState} from 'vuex'

    export default {
        mounted() {
            $(window).on('scroll', function () {
                $('.page-component-up')[($(this).scrollTop() > 50)?"fadeIn":"fadeOut"]();
            })
        },
        methods: {
            testClick(){
                this.$router.push('/client')
            },
            gotop() {
                $('body,html').animate({scrollTop: 0}, 800)
            }
        },
        components: {
            News,
            Popular,
            DataShow
        }
    }

</script>


<style scoped>
    .dataShow {
        margin-top: 3%;
        text-align: -webkit-center;

    }

    .news {
        text-align: -webkit-center;

    }

    .popular {
        text-align: -webkit-center;

    }

    .page-component-up {
        background-color: #fff;
        position: fixed;
        right: 100px;
        bottom: 150px;
        width: 40px;
        height: 40px;
        border-radius: 20px;
        cursor: pointer;
        transition: .3s;
        box-shadow: 0 0 6px rgba(0, 0, 0, .12);
    }
    .page-component-up i{
        position: relative;
        left:3px;
        top:3px;
    }
    .el-icon-caret-top {
        color: #409eff;
        display: block;
        line-height: 40px;
        text-align: center;
        font-size: 18px;
    }
</style>

