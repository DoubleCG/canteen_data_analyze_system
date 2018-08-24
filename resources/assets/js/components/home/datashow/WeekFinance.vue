
<template>
    <div class="news">
            <div class="title"> 本周营业数据 </div>
        <ve-histogram :data="chartData"></ve-histogram>
    </div>
</template>

<script>
import VeHistogram from 'v-charts/lib/histogram.common';

    export default {
        components:{
            VeHistogram
        },
        mounted() {
            this.newChart();
            setInterval(this.newChart,REFRESHTIME.weekFinance);
        },
        data() {
            return {
                chartData: {
                  columns: ['date', 'cost', 'profit', 'growthRate', 'people'],
                  rows: [
                    { 'cost': 1523, 'date': '01/01', 'profit': 1523, 'growthRate': 0.12, 'people': 100 },
                    { 'cost': 1223, 'date': '01/02', 'profit': 1523, 'growthRate': 0.345, 'people': 100 },
                    { 'cost': 2123, 'date': '01/03', 'profit': 1523, 'growthRate': 0.7, 'people': 100 },
                    { 'cost': 4123, 'date': '01/04', 'profit': 1523, 'growthRate': 0.31, 'people': 100 }
                  ]
                },
                date_order_number: [],
                data_money: []
            };
        },
        methods:{

            newChart(){
                let vm = this;
                axios.get('/api/home/weekFinance')
                    .then(response => {
                        let data = response.data;
                        console.log('/api/home/weekFinance:');
                        console.log(data);
                        let data_order_number = [];
                        let data_money = [];
                        for(let i=0;i<7;i++){
                            data_order_number[i] = 0;
                            data_money[i] = 0;
                        }

                        for(let i=0,l=data.length;i<l;i++){
                            let day_in_week = new Date(parseInt(data[i].paytime+'000')).getDay()-1;
                            data_order_number[day_in_week] ++;
                            let foods = JSON.parse(data[i].foods.replace('\\',''));
                            for(let food of foods){
                                data_money[day_in_week] += food.price * food.number;
                            }
                        }

                        vm.data_order_number = data_order_number;
                        vm.data_money = data_money;
                        refresh()
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                function refresh(){
                    let ctx = document.getElementById('canvas-WeekFinance').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['周日','周一','周二','周三','周四','周五','周六'],
                            datasets: [{
                                label: "订单数",
                                backgroundColor: "#e81b1b",
                                data: vm.data_order_number,
                            },{
                                label: "营业额",
                                backgroundColor: "#3cC250",
                                data: vm.data_money,
                            }]
                        },
                        options: {}
                    });
                }
            }
        }
    }
</script>



<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 1%;
        margin-top: 10rem;
    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border-radius: 20px;
        background-color: #3394c7;
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






