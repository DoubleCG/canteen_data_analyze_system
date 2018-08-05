<template>
    <div class="news">
        <div class="title"> 支付方式 </div>
        <div class="below">
            <!-- <chart :options="chartData" class="chart"></chart> -->
        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 2%;
        margin-right: 1%;
    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #888888;
        border-radius: 20px;
        background-color: #888888;
        width: 20%;
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
    import echarts from 'echarts'

    export default {
        mounted() {


        },

        methods: {
            cleanData() {
                this.chartData = null;
            },
            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };


                axios.get('/api/finance/payType',
                    {
                        params: queryData,
                    }
                ).then(response => {
                    for (let i = _.size(response.data) - 1; i >= 0; i--) {
                        if (response.data[i].payType == 'K') {
                            this.Kdata.value = response.data[i].count;
                        }
                        if (response.data[i].payType == 'Z') {
                            this.Zdata.value = response.data[i].count;
                        }
                        if (response.data[i].payType == 'W') {
                            this.Wdata.value = response.data[i].count;
                        }
                        if (response.data[i].payType == 'X') {
                            this.Xdata.value = response.data[i].count;
                        }

                    }
                    var colors = ['#5793f3', '#d14a61', '#675bba'];

                    this.chartData = {

                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b}: {c} ({d}%)"
                        },
                        legend: {
                            data: ['饭卡', '支付宝', '微信', '现金']
                        },
                        series: [
                            {
                                name: '支付方式',
                                type: 'pie',
                                radius: ['50%', '70%'],
                                avoidLabelOverlap: false,
                                label: {
                                    normal: {
                                        show: false,
                                        position: 'center'
                                    },
                                    emphasis: {
                                        show: true,
                                        textStyle: {
                                            fontSize: '30',
                                            fontWeight: 'bold'
                                        }
                                    }
                                },
                                labelLine: {
                                    normal: {
                                        show: false
                                    }
                                },
                                data: [
                                    this.Kdata,
                                    this.Zdata,
                                    this.Wdata,
                                    this.Xdata,
                                ]
                            }
                        ]
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        },


        data() {
            return {
                chartData: null,
                Kdata: {value: 0, name: '饭卡'},
                Zdata: {value: 0, name: '支付宝'},
                Wdata: {value: 0, name: '微信'},
                Xdata: {value: 0, name: '现金'},
            };
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
