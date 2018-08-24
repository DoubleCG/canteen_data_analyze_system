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
                    <ve-line :data="chartData"></ve-line>
                </div>
            </div>
        </div>
    </div>


</template>

<style scoped>
.echarts {
  height: 300px;
}
    .money-over-view {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-left: 1%;
    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border-radius: 20px;
        background-color: #3394c7;
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

import VeLine from 'v-charts/lib/line.common';

    export default {
        components:{
             VeLine
        },
        mounted() {
            this.newChart();
            // setInterval(this.newChart,REFRESHTIME.moneyOverView);
        },
        methods :{
            downloadExcel(){
                axios.get('/api/downloadExcel')
                .then(response=>{
                    console.log('/api/downloadExcel');
                    console.log(response);
                })
                .catch(error=>{
                    console.log(error);
                })
            },
            go(){
                this.$router.push('/finance');
            },
            newChart(){
                let vm = this;
                axios.get('/api/home/moneyOverView')
                    .then(response => {
                        console.log('/api/home/moneyOverView');
                        console.log(response);
                        let data = response.data;
                        let rows=vm.chartData.rows;
                        for(let i=0,l=data.length;i<l;i++){
                            let h = new Date(parseInt(data[i].paytime+'000')).getHours();
                            rows[h]["订单量"]++;
                            let foods = JSON.parse(data[i].foods.replace('\\',''));
                            let totalMoney = 0;
                            for(let food of foods){
                                totalMoney += food.price * food.number;
                            }
                            rows[h]["营业额"] += totalMoney;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        data() {
            return {
                chartData: {
                    columns: ['time', '订单量',"营业额"],
                    rows: [
                      { 'time': '0h', '订单量': 0 ,"营业额":0},
                      { 'time': '1h', '订单量': 0 ,"营业额":0},
                      { 'time': '2h', '订单量': 0 ,"营业额":0},
                      { 'time': '3h', '订单量': 0 ,"营业额":0},
                      { 'time': '4h', '订单量': 0 ,"营业额":0},
                      { 'time': '5h', '订单量': 0 ,"营业额":0},
                      { 'time': '6h', '订单量': 0 ,"营业额":0},
                      { 'time': '7h', '订单量': 0 ,"营业额":0},
                      { 'time': '8h', '订单量': 0 ,"营业额":0},
                      { 'time': '9h', '订单量': 0 ,"营业额":0},
                      { 'time': '10h', '订单量': 0 ,"营业额":0},
                      { 'time': '11h', '订单量': 0 ,"营业额":0},
                      { 'time': '12h', '订单量': 0 ,"营业额":0},
                      { 'time': '13h', '订单量': 0 ,"营业额":0},
                      { 'time': '14h', '订单量': 0 ,"营业额":0},
                      { 'time': '15h', '订单量': 0 ,"营业额":0},
                      { 'time': '16h', '订单量': 0 ,"营业额":0},
                      { 'time': '17h', '订单量': 0 ,"营业额":0},
                      { 'time': '18h', '订单量': 0 ,"营业额":0},
                      { 'time': '19h', '订单量': 0 ,"营业额":0},
                      { 'time': '20h', '订单量': 0 ,"营业额":0},
                      { 'time': '21h', '订单量': 0 ,"营业额":0},
                      { 'time': '22h', '订单量': 0 ,"营业额":0},
                      { 'time': '23h', '订单量': 0 ,"营业额":0}
                    ]
                }
            }
        },
        computed:{
            OrderNumber(){
                let rows = this.chartData.rows;
                let ordernumber = 0;
                for(let i=0,l=rows.length;i<l;i++){
                    ordernumber += rows[i]["订单量"];
                }
                return ordernumber;
            },
            TotalMoney(){
                let rows = this.chartData.rows;
                let totalmoney = 0;
                for(let i=0,l=rows.length;i<l;i++){
                    totalmoney += rows[i]["营业额"];
                }
                return totalmoney;
            },

        }


    }
</script>
