<template>
    <div :span="12" class="news">
        <div :span="12" class="moneyOverView">
            <div class="title"> 最新动态 </div>
            <div class="content">
                <li v-for='item in newslist'>
                    [{{item.paytime}}] 手机{{item.phone}} 支付 {{item.money}} 元，清单：
                    <div v-for='food in item.foods'>
                        {{food.name}} : {{food.price}}元 * {{food.number}}份
                    </div>
                -------------------------------------------------------------
                </li>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        mounted(){
            this.checkNews();

        },
        data(){
            return{
                newslist:[{
                    phone:'123456***456',
                    paytype:'支付宝',
                    money:100,
                    paytime:"12:06:12",
                    foods:[{
                        name:'锦鲤抄',
                        number:2,
                        price:21
                    },{
                        name:'炒饭',
                        number:3,
                        price:14
                    },{
                        name:'果冻',
                        number:48,
                        price:34
                    }]
                }],
            }
        },
        methods:{
            checkNews(){
                axios.get('/api/news')
                .then(response=>{
                    console.log(response)
                })
                .catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>


<style scoped>
    .news{
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 1%;
    }
    .title{
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #20a0ff;
        border-radius: 20px;
        background-color: #20a0ff;
        width: 20%;
        color: #FFFFFF;
        font-size: 18px;
    }
    .content{
        overflow-y: scroll;
        width:90%;
        height:400px;
        margin:5%;
    }
</style>
