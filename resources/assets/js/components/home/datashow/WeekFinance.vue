
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
                  columns: ['weekday','订单数','营业额'],
                  rows: [
                    { 'weekday': '周一', '订单数':0, '营业额':0 },
                    { 'weekday': '周二', '订单数':0, '营业额':0  },
                    { 'weekday': '周三', '订单数':0, '营业额':0  },
                    { 'weekday': '周四', '订单数':0, '营业额':0  },
                    { 'weekday': '周五', '订单数':0, '营业额':0  },
                    { 'weekday': '周六', '订单数':0, '营业额':0  },
                    { 'weekday': '周日', '订单数':0, '营业额':0  }
                  ]
                },
            };
        },
        methods:{

            newChart(){
                let vm = this;
                axios.get('/api/home/weekFinance')
                    .then(response => {
                        let data = response.data;
                        console.log('/api/home/weekFinance:');
                        let data_order_number = [];
                        let data_money = [];
                        let rows = vm.chartData.rows;
                        for(let i=0,l=data.length;i<l;i++){
                            let day_in_week = new Date(parseInt(data[i].paytime+'000')).getDay()-1;
                            rows[day_in_week]['订单数'] ++;
                            let foods = JSON.parse(data[i].foods.replace('\\',''));
                            for(let food of foods){
                                rows[day_in_week]['营业额'] += food.price * food.number;
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
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






