<template>
    <div>
        <div>
            <div v-model="activeName2" type="card" @tab-click="handleClick">
<!--                 <el-tab-pane label="菜品销量分析" name="salesAnal"></el-tab-pane>
                <el-tab-pane label="菜品销量查询" name="salesSearch"></el-tab-pane> -->
            </div>
        </div>

        <div>
            <router-view></router-view>
        </div>

        <div v-show="false" @click="gotop" class="page-component-up">
            <i @click="gotop" class="el-icon-caret-top"></i>
        </div>

    </div>
</template>


<style scoped>

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

    .el-icon-caret-top {
        color: #409eff;
        display: block;
        line-height: 40px;
        text-align: center;
        font-size: 18px;
    }



</style>

<script>

    export default {
        mounted() {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 50) {
                    $('.page-component-up').fadeIn()
                } else {
                    $('.page-component-up').fadeOut()
                }
            })
        },


        data() {
            return {

                activeName2: 'first'
            };
        },
        methods: {


            gotop() {
                $('body,html').animate({scrollTop: 0}, 800)
            },
            handleClick(tab) {
                let name = tab.name;
                if(name === 'salesAnal'){
                    this.$router.push('/sales/salesAnal');
                }else if(name == 'salesSearch'){
                    this.$router.push('/sales/salesSearch');
                }
            },

        }
    };
</script>


