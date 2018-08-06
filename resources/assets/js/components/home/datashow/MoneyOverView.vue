<template>
    <div class="money-over-view">
        <div class="title"  @click.native="go">
            今日营业状况
        </div>
        <div class="content">
            <div :span="5" class="number">
                <div class="orderNumberRow">
                    <div class="numTitle">
                        订单数:{{ OrderNumber }} / 营业额:{{ TotalMoney }}
                        <i
                            title='导出Excel'
                            style='float:right;margin-right:10px;'
                            class='icono-caretDownSquare'
                            @click='downloadExcel'
                        ></i>
                    </div>
<!--                     <div>
                        总量 <span class="OrderNumber">  </span> 件
                    </div>
                    <canvas id='canvas-MoneyOverView-OrderNumber'></canvas> -->
                    <canvas id='canvas'></canvas>
                </div>
<!--                 <div class="orderNumberRow">
                    <div class="numTitle">

                    </div>
                    <div>
                        总计 <span class="TotalMoney"></span> 元
                    </div>
                    <canvas id='canvas-MoneyOverView-TotalMoney'></canvas>
                </div> -->
            </div>
        </div>

    </div>


</template>

<style scoped>
    .money-over-view {
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
    export default {
        components:{
        },
        mounted() {
            let vm = this;
            axios.get('/api/home/moneyOverView')
                .then(response => {
                    console.log('/api/home/moneyOverView');
                    console.log(response);
                    let data = response.data;
                    let record_data_orderNumber = [];
                    let record_data_totalMoney = [];
                    for(let i=0;i<24;i++){
                        record_data_orderNumber.push(0);
                        record_data_totalMoney.push(0);
                    }
                    for(let i=0,l=data.length;i<l;i++){
                        let h = new Date(parseInt(data[i].paytime+'000')).getHours();
                        record_data_orderNumber[h] ++;
                        let foods = JSON.parse(data[i].foods.replace('\\',''));
                        for(let food of foods){
                            record_data_totalMoney[h] += food.price * food.number;
                        }
                    }

                    console.log(record_data_orderNumber);
                    console.log(record_data_totalMoney);
                    vm.data_orderNumber = record_data_orderNumber;
                    vm.data_totalMoney = record_data_totalMoney;
                    vm.newChart();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods :{
            downloadExcel(){
                console.log('downloadExcel');
                axios.get('/')
            },
            go(){
                this.$router.push('/finance');
            },
            newChart(){
                // let canvas_OrderNumber = document.getElementById('canvas-MoneyOverView-OrderNumber').getContext('2d');
                let canvas = document.getElementById('canvas').getContext('2d');
                let vm = this;
                // new Chart(canvas_OrderNumber, {
                new Chart(canvas, {
                    // The type of chart we want to create
                    type: 'line',
                    // The data for our dataset
                    data: {
                        labels: vm.labels,
                        datasets: [{
                            label: "订单数",
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(255, 99, 132)',
                            data: vm.data_orderNumber,

                        },{
                            label: "营业额",
                            backgroundColor: 'transparent',
                            borderColor: '#635148',
                            data: vm.data_totalMoney,
                        }]
                    },
                    // Configuration options go here
                    options: {}
                });
                setTimeout(vm.newChart,60000);
            }
        },
        data() {
            return {
                labels:["0h","1h","2h","3h","4h","5h","6h","7h","8h","9h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h"],
                data_orderNumber:[],
                data_totalMoney:[],
                chartData: null,
            };
        },
        computed:{
            OrderNumber(){
                // return _(this.data_orderNumber);
                return _.sum(this.data_orderNumber);
            },
            TotalMoney(){
                return _.sum(this.data_totalMoney);
            },
        }


    }
</script>
