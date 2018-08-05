<template>
    <div class="news">
        <div class="title">
            财务概览
        </div>
        <div class="content">
            <div :span="6" class="number">
                <div class="orderNumberRow">
                    <div class="numTitle">
                        订单数量
                    </div>
                    <div>
                        总量 <span class="OrderNumber"> {{ OrderNumber }} </span> 件
                    </div>
                </div>
                <div>
                    <div class="numTitle">
                        营业额
                    </div>
                    <div>
                        总计 <span class="TotalMoney">{{ TotalMoney }}</span> 元
                    </div>
                </div>

            </div>
            <div :span="9">
                <!-- <chart :options="chartData" class="chart"></chart> -->
            </div>
            <div :span="9">
                <!-- <chart :options="chartData1" class="chart"></chart> -->
            </div>

        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 1%;
    }

    .title {
        margin: -10px auto 2%;
        text-align: center;
        border: solid 1px #888888;
        border-radius: 20px;
        background-color: #888888;
        width: 20%;
        color: #FFFFFF;
        font-size: 18px;
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
                queryData1: null,
                OrderNumber: null,
                TotalMoney: null,
                data1: [],
                data2: [],
                chartData: null,
                chartData1: null,

            };
        },

        methods: {
            cleanData() {
                this.queryData = null;
                this.queryData1 = null;
                this.OrderNumber = null;
                this.TotalMoney = null;
                this.data1 = [];
                this.data2 = [];
                this.chartData = null;
                this.chartData1 = null;
            },
            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };


                let timePast = differenceInDays(this.date[1], this.date[0]);

                let newTimeStart = addDays(this.date[0], -timePast);
                let newTimeEnd = addDays(this.date[1], -timePast);

                let queryData1 = {
                    timeStart: newTimeStart,
                    timeEnd: newTimeEnd,
                    device: window.localStorage.getItem('device'),
                };




                axios.all([
                    axios.get('/api/finance/orderNum', {
                        params: queryData,
                    })
                    ,
                    axios.get('/api/finance/orderNum', {
                        params: queryData1,
                    })
                ])
                    .then(axios.spread((data1, data2) => {
                        this.OrderNumber = data1.data[0].count;

                        this.chartData = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            grid: {
                                containLabel: true,
                                left: ['5%'],
                                right: ['5%'],
                            },
                            legend: {
                                data: ['所选', '同期']
                            },
                            calculable: true,
                            xAxis: [
                                {
                                    type: 'category',
                                    data: ['订单数量'],

                                }
                            ],
                            yAxis: [
                                {
                                    type: 'value',

                                }
                            ],
                            series: [
                                {
                                    name: '所选',
                                    type: 'bar',
                                    data: [data1.data[0].count],

                                },
                                {
                                    name: '同期',
                                    type: 'bar',
                                    data: [data2.data[0].count],
                                }
                            ]
                        }

                        // console.log(data2);
                    })).catch(function (error) {
                    console.log(error);
                });


                axios.all([
                    axios.get('/api/finance/turnover', {
                        params: queryData,
                    })
                    ,
                    axios.get('/api/finance/turnover', {
                        params: queryData1,
                    })
                ])
                    .then(axios.spread((data1, data2) => {
                        console.log(data1);
                        console.log(data2);
                        this.TotalMoney = data1.data[0].money;

                        this.chartData1 = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            grid: {
                                containLabel: true,
                                left: ['5%'],
                                right: ['5%'],
                            },
                            legend: {
                                data: ['所选', '同期']
                            },
                            calculable: true,
                            xAxis: [
                                {
                                    type: 'category',
                                    data: ['营业额'],

                                }
                            ],
                            yAxis: [
                                {
                                    type: 'value',

                                }
                            ],
                            series: [
                                {
                                    name: '所选',
                                    type: 'bar',
                                    data: [data1.data[0].money],

                                },
                                {
                                    name: '同期',
                                    type: 'bar',
                                    data: [data2.data[0].money],
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
                this.cleanData();
                this.postData();
            }
        },


        props: {
            'date': {
                required: false
            }
        },


    }
</script>
