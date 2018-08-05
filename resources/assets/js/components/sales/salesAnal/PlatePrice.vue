<template>
    <div class="news">
        <div class="title"> 餐盘价格分布 </div>
        <div class="below">
            <!-- <chart :options="chartData" class="chart"></chart> -->
        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
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
    import echarts from 'echarts'

    export default {
        mounted() {

        },

        methods: {
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
                        this.chartData = null;

                        let total = 0;
                        let div1 = 0;
                        let div2 = 0;
                        let tmp = 0;
                        let count = [0,0,0];
                        let name = [];
                        let firstData = [];
                        let secondData = [];

                        for (let i = 0; i < _.size(response.data); i++) {
                            total = total + response.data[i].count;
                        }
                        for (let i = 0; i < _.size(response.data); i++) {
                            tmp = tmp + response.data[i].count;
                            if(tmp > (total / 3)){
                                div1 = Math.floor(response.data[i].money);
                                break;
                            }
                        }
                        tmp = 0;
                        for (let i = 0; i < _.size(response.data); i++) {
                            tmp = tmp + response.data[i].count;
                            if(tmp > (2* total / 3)){
                                div2 = Math.floor(response.data[i].money);
                                break;
                            }
                        }

                        name[0] = div1 + '元以下';
                        name[1] = div1 + '-' + div2 + '元';
                        name[2] = div2 + '元以上';



                        for (let i = 0; i < _.size(response.data); i++) {
                            if(response.data[i].money < div1){
                                secondData.push({'value':response.data[i].count, 'name':response.data[i].money});
                                count[0] = count[0] + response.data[i].count;
                            }
                            if(response.data[i].money < div2 && response.data[i].money >= div1){
                                secondData.push({'value':response.data[i].count, 'name':response.data[i].money});
                                count[1] = count[1] + response.data[i].count;
                            }
                            if(response.data[i].money >= div2){
                                secondData.push({'value':response.data[i].count, 'name':response.data[i].money});
                                count[2] = count[2] + response.data[i].count;
                            }
                        }

                        console.log(count);

                        for(let i =0; i < 3; i++){
                            firstData.push({'value':count[i], 'name':name[i]});
                        }


                        console.log(firstData);


                        this.chartData = {
                            tooltip: {
                                trigger: 'item',
                                formatter: "{b}: {c} ({d}%)"
                            },
                            grid: {
                                containLabel: true,
                                left: ['0%'],
                                right: ['0%'],
                            },
                            series: [
                                {
                                    type:'pie',
                                    selectedMode: 'single',
                                    radius: [0, '50%'],

                                    label: {
                                        normal: {
                                            position: 'inner'
                                        }
                                    },
                                    labelLine: {
                                        normal: {
                                            show: false
                                        }
                                    },
                                    data:firstData
                                },
                                {
                                    type:'pie',
                                    radius: ['55%', '70%'],
                                    label: {
                                        normal: {
                                            formatter: '  {b|{b}：}{c}  {per|{d}%}  ',
                                            backgroundColor: '#eee',
                                            borderColor: '#aaa',
                                            borderWidth: 1,
                                            borderRadius: 4,
                                            rich: {
                                                b: {
                                                    fontSize: 16,
                                                    lineHeight: 33
                                                },
                                                per: {
                                                    color: '#eee',
                                                    backgroundColor: '#334455',
                                                    padding: [2, 4],
                                                    borderRadius: 2
                                                }
                                            }
                                        }
                                    },
                                    data:secondData
                                }
                            ]                        }
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
