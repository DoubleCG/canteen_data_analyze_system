<template>
    <div class="news">
        <div class="title">订单金额分布情况</div>
        <div>
            <!-- <chart :options="chartData" class="chart"></chart> -->
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
    import echarts from 'echarts'

    export default {
        mounted() {

        },

        methods: {

            cleanData() {
                this.chartData = null;
                this.countData = [];
                this.moneyData = [];
            },


            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };


                axios.get('/api/finance/oderMoneyDistribute', {
                    params: queryData
                })
                    .then(response => {
                        for (let i = 0; i < _.size(response.data); i++) {
                            this.countData.push(response.data[i].count);
                            this.moneyData.push(response.data[i].money);
                        }
                        console.log(this.countData);
                        console.log(this.moneyData);


                        this.chartData = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['销量']
                            },

                            calculable: true,
                            xAxis: [{
                                type: 'category',
                                data: this.moneyData,
                            }],
                            yAxis: [{
                                type: 'value'
                            }],
                            grid: {
                                containLabel: true,
                                left: ['5%'],
                                right: ['5%'],
                            },
                            series: [{
                                name: '销量',
                                type: 'bar',
                                data: this.countData,
                                itemStyle: {
                                    normal: {
                                        color: function (params) {
                                            // build a color map as your need.
                                            // var colorList = [
                                            //     '#C1232B', '#B5C334', '#FCCE10', '#E87C25', '#27727B',
                                            //     '#FE8463', '#9BCA63', '#FAD860', '#F3A43B', '#60C0DD',
                                            //     '#D7504B', '#C6E579', '#F4E001', '#F0805A', '#26C0C0'
                                            // ];
                                            // return colorList[params.dataIndex]


                                            return "#" + Math.floor(Math.random() * (256 * 256 * 256 - 1)).toString(16);


                                        }
                                    }
                                }
                            }]
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            }
        },


        data() {
            return {
                chartData: null,
                countDate: [],
                moneyData: [],
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
