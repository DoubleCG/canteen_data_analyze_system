<template>
    <div class="paytype">
        <div class="title">支付方式</div>
        <canvas id='canvas-PayType'></canvas>
    </div>


</template>

<style scoped>
    .paytype {
        margin-top:30px;
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

    export default {
        mounted() {
            this.newChart();

            axios.get('/api/home/payType')
                .then(response => {









                    if(true){
                        return;
                    }

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
        },
        data() {
            return {
                chartData: null,
                Kdata: {value: 0, name: '饭卡'},
                Zdata: {value: 0, name: '支付宝'},
                Wdata: {value: 0, name: '微信'},
                Xdata: {value: 0, name: '现金'},
                labels:['饭卡','支付宝','微信','现金'],
                data3:[1,3,4,5]
            };
        },
        methods:{
            newChart(){
                let ctx = document.getElementById('canvas-PayType').getContext('2d');
                let vm = this;
                new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'pie',

                    // The data for our dataset
                    data: {
                        labels: vm.labels,
                        datasets: [{
                            label: "My First dataset",
                            backgroundColor: ["#036497","#995642","#236666",'#816'],
                            data: vm.data3,
                        }]
                    },

                    // Configuration options go here
                    options: {}
                });
            }
        }


    }
</script>
