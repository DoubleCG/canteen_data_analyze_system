<template>
    <div class="news">
        <div class="title">
            历史客流
        </div>
        <div>
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
        },
        data() {
            return {
                chartData: null,
                countDate: [],
                dateData: [],
                queryData: null,
            };
        },

        methods: {

            cleanData() {
                this.chartData = null;
                this.countData = [];
                this.dateData = [];
            },

            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };

                console.log(queryData);


                axios.get('/api/finance/turnoverDetail', {
                    params: queryData
                })
                    .then(response => {

                        console.log(response);
                        for (let i = 0 ; i <  _.size(response.data); i++) {
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
                                data: ['客流量']
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
                                    name: '客流量',
                                    axisLabel: {
                                        formatter: '{value} 人次'
                                    }
                                }
                            ],
                            series: [
                                {
                                    name: '订单数量',
                                    type: 'line',
                                    smooth: true,
                                    data: this.countData,
                                }
                            ]
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            }
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
