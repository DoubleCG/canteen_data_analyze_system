<template>
    <div class="news">
        <div class="title"> 菜品基本信息 </div>
        <div class="content">
            <div :span="8" class="number" v-if="foodInfo">


                <div type="flex" align="bottom">
                    <div :span="12" :offset="1">菜品名称</div>

                    <div :span="11">{{ foodInfo[0].dishname }}</div>

                </div>
                <div type="flex" align="bottom">

                    <div :span="12" :offset="1">菜品编号</div>
                    <div :span="11">{{ foodInfo[0].foodID }}</div>
                </div>
                <div type="flex" align="bottom">

                    <div :span="12" :offset="1">单价</div>
                    <div :span="11">{{ foodInfo[0].price }}</div>
                </div>
                <div type="flex" align="bottom">

                    <div :span="12" :offset="1">销量</div>
                    <div :span="11">{{ foodInfo[0].count }}</div>
                </div>
                <div type="flex" align="bottom">

                    <div :span="12" :offset="1">营业额</div>
                    <div :span="11">{{ foodInfo[0].sales }}</div>
                </div>

            </div>
            <div :span="16">
                <!-- <chart :options="chartData" class="chart"></chart> -->
            </div>

        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-top: 2%;

    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #888888;
        border-radius: 20px;
        background-color: #888888;
        width: 30%;
        color: #FFFFFF;
        font-size: 18px;
        margin-bottom: 2%;
    }

    .number {
        border-right: solid 1px #e6e6e6;

    }

    .numTitle {
        text-align: left;
        margin-left: 10%;
        font-size: 18px;
        font-weight: bold;
    }

    .content {
        margin-bottom: 2%;
    }

    .orderNumberRow {
        margin-bottom: 10%;
    }

    .OrderNumber {
        font-weight: bold;
        font-size: 17px;
    }

    .TotalMoney {
        font-weight: bold;
        color: #20a0ff;
        font-size: 17px;
    }

    .chart {
        width: calc(100%) !important;
        height: 300px !important;
    }
</style>

<script>
    import echarts from 'echarts'
    import differenceInDays from 'date-fns/difference_in_days'
    import addDays from 'date-fns/add_days'


    export default {
        mounted() {


        },
        data() {
            return {
                queryData: null,
                foodInfo: null,
                data1: [],
                data2: [],
                chartData: null,
                chartData1: null,

            };
        },

        methods: {
            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                    food: this.food,
                };

                axios.all([
                    axios.get('/api/sales/foodInfo', {
                        params: queryData,
                    })
                    ,
                    axios.get('/api/finance/turnover', {
                        params: queryData,
                    })
                ])
                    .then(axios.spread((data1, data2) => {

                        this.queryData = null;
                        this.foodInfo = null;
                        this.data1 = [];
                        this.data2 = [];
                        this.chartData = null;
                        this.chartData1 = null;


                        this.foodInfo = data1.data;
                        console.log(data2);
                        this.chartData = {


                            tooltip : {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },

                            series : [
                                {
                                    name: '营业额',
                                    type: 'pie',
                                    radius : '55%',
                                    center: ['50%', '60%'],
                                    data:[
                                        {value:this.foodInfo[0].sales, name: this.foodInfo[0].dishname},
                                        {value:data2.data[0].money - this.foodInfo[0].sales, name:'其他'},

                                    ],
                                    itemStyle: {
                                        emphasis: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                        }
                                    }
                                }
                            ]

                        }


                        // console.log(data2);
                    })).catch(function (error) {
                    console.log(error);
                });

            },

        },

        watch: {
            date: function () {
                this.postData();
            },
            food: function () {
                this.postData();
            }
        },


        props: {
            'date': {
                required: false
            },
            'food':{
                required: false
            }
        },


    }
</script>
