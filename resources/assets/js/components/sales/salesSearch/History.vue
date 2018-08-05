<template>
    <div class="news">
        <div class="title"> 菜品单品历史销量 </div>
        <div class="content">
            <!-- <chart :options="chartData" class="chart"></chart> -->
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
                chartData: null,
                countData: [],
                dateData: [],

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


                axios.get('/api/sales/foodSales', {
                    params: queryData
                })
                    .then(response => {

                        this.chartData = null;
                        this.countData = [];
                        this.dateData = [];


                        console.log(response);
                        for (let i = 0; i < _.size(response.data); i++) {
                            this.countData.push(response.data[i].count);
                            this.dateData.push(response.data[i].date);
                        }

                        this.chartData = {
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'cross',
                                    crossStyle: {
                                        color: '#999'
                                    }
                                }
                            },
                            grid: {
                                containLabel: true,
                                left: ['5%'],
                                right: ['5%'],
                            },
                            legend: {
                                data: ['销量']
                            },
                            xAxis: [
                                {
                                    type: 'category',
                                    data: this.dateData,
                                    axisPointer: {
                                        type: 'shadow'
                                    }
                                }
                            ],
                            yAxis: [
                                {
                                    type: 'value',
                                    name: '销量',
                                    axisLabel: {
                                        formatter: '{value} 件'
                                    }
                                }
                            ],
                            series: [
                                {
                                    name: '销量',
                                    type: 'line',
                                    smooth: true,
                                    data: this.countData,
                                }
                            ]
                        }
                    }).catch(function (error) {
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
            'food': {
                required: false
            }
        },


    }
</script>
