<template>
    <div class="news">
        <div class="title"> 本周营业数据 </div>
        <canvas id='canvas-WeekFinance'></canvas>
    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 1%;
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

    .chart {
        width: calc(100%) !important;
        height: 300px !important;
    }
</style>

<script>
    export default {
        mounted() {
            this.newChart();

            axios.get('/api/home/weekFinance')
                .then(response => {


                    if(true){
                        return;
                    }
                    for (let i = _.size(response.data) - 1; i >= 0; i--) {
                        this.date.push(response.data[i].date);
                        this.moneyData.push(response.data[i].money)
                    }

                    var colors = ['#5793f3', '#d14a61', '#675bba'];

                    this.chartData = {
                        color: colors,
                        toolbox: {
                            right: '10%',
                            feature: {
                                saveAsImage: {}
                            }
                        },
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross'
                            }
                        },

                        xAxis: [
                            {
                                type: 'category',
                                axisTick: {
                                    alignWithLabel: true
                                },
                                axisLine: {
                                    onZero: false,
                                },
                                data: this.date,
                            },
                        ],
                        yAxis: [
                            {
                                type: 'value',
                                name: '营业额',
                                position: 'left',
                                axisLine: {
                                    lineStyle: {
                                        color: colors[0]
                                    }
                                },
                                axisLabel: {
                                    formatter: '{value} 元',
                                }
                            },
                        ],
                        series: [

                            {
                                name: '营业额',
                                type: 'line',
                                smooth: true,
                                data: this.moneyData,
                                markPoint: {
                                    data: [
                                        {
                                            coord: [6, this.moneyData[6]], name: '今日',
                                            label: {
                                                normal: {
                                                    formatter: '{b}'

                                                }
                                            }
                                        }
                                    ]
                                },
                            }
                        ]
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        data() {
            return {
                chartData: null,
                date: [],
                moneyData: [],
            };
        },
        methods:{
            newChart(){

               let ctx = document.getElementById('canvas-WeekFinance').getContext('2d');
                let vm = this;
                new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: ['周一','周二','周三','周四','周五','周六','周日'],
                        datasets: [{
                            label: "订单数",
                            backgroundColor: "#036497",
                            data: [1,2,3,4,5,7,8],
                        },{
                            label: "营业额",
                            backgroundColor: "#974512",
                            data: [1,2,3,4,5,7,8],
                        }]
                    },

                    // Configuration options go here
                    options: {}
                });
            }
        }


    }
</script>
