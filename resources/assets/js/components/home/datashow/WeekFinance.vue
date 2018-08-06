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
            let vm = this;
            axios.get('/api/home/weekFinance')
                .then(response => {
                    console.log(response.data);
                    let data = response.data;
                    let data_order_number = [];
                    let data_money = [];
                    for(let i=0;i<7;i++){
                        data_order_number[i] = 0;
                        data_money[i] = 0;
                    }

                    for(let i=0,l=data.length;i<l;i++){
                        let day_in_week = new Date(parseInt(data[i].paytime+'000')).getDay();
                        data_order_number[day_in_week] ++;
                        let foods = JSON.parse(data[i].foods.replace('\\',''));
                        for(let food of foods){
                            data_money[day_in_week] += food.price * food.number;
                        }
                    }

                    vm.data_order_number = data_order_number;
                    vm.data_money = data_money;
                    vm.newChart();
                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        data() {
            return {
                date_order_number: [],
                data_money: []
            };
        },
        methods:{
            newChart(){

                let ctx = document.getElementById('canvas-WeekFinance').getContext('2d');
                let vm = this;
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['周一','周二','周三','周四','周五','周六','周日'],
                        datasets: [{
                            label: "订单数",
                            backgroundColor: "#036497",
                            data: vm.data_order_number,
                        },{
                            label: "营业额",
                            backgroundColor: "#974512",
                            data: vm.data_money,
                        }]
                    },
                    options: {}
                });


                setTimeout(vm.newChart,60000);
            }
        }
    }
</script>
