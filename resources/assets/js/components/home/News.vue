<template>
    <div :span="12" class="news">
        <div :span="12" class="moneyOverView">
            <div class="title"> 最新动态 </div>
            <div class="content">
                <li v-for='item in newslist'>
                    {客户端{{item.clientid}}} - [{{item.paytime}}] 手机{{item.phone}} 支付 {{item.money}} 元，清单：
                    <br>订单号：{{item.order_num}}
                    <div v-for='food in item.foods'>
                        · {{food.name}} : {{food.price}}元 * {{food.number}}份
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
            console.log("news mounted")
            setInterval(this.checkNews,5000);
        },
        data(){
            return{
                newslist:[{
                    "clientid": "001",
                    "phone": "12345678910",
                    "order_num":"646da41f8wfa1fa3f164986",
                    "paytype": "X",
                    "money": "100",
                    "paytime": "2018-05-21 12:06:12",
                    "foods": [{
                        "name": "锦鲤抄",
                        "number": 2,
                        "price": 21
                    }, {
                        "name": "炒饭",
                        "number": 3,
                        "price": 14
                    }, {
                        "name": "果冻",
                        "number": 48,
                        "price": 34
                    }]
                },{
                    "clientid": "001",
                    "phone": "12345678910",
                    "order_num":"646da41f8wfa1fa3f164986",
                    "paytype": "X",
                    "money": "100",
                    "paytime": "2018-05-21 12:06:12",
                    "foods": [{
                        "name": "锦鲤抄",
                        "number": 2,
                        "price": 21
                    }, {
                        "name": "炒饭",
                        "number": 3,
                        "price": 14
                    }, {
                        "name": "果冻",
                        "number": 48,
                        "price": 34
                    }]
                }],
            }
        },
        methods:{
            checkNews(){
                let vm = this;
                axios.get('/api/news')
                .then(response=>{
                    let data  = response.data;
                    console.log("getNews:",data);
                    while(data.length){
                        let content = data.shift().content.replace('\\','').replace('\n','');
                        vm.newslist.unshift(JSON.parse(content));
                    }
                })
                .catch(error=>{
                    console.log(error);
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
        border-radius: 20px;
        background-color: #3394c7;
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
