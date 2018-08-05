<template>
    <div class="news">
        <div class="title" v-tooltip.top="'something to explain'">
            最佳搭配TOP5
        </div>
        <div class="content">
            <div :span="8" :offset="1">
                <div v-for="(food, index) in foodData" :key="food.foodname" v-if="index<5">
                    {{ food.package }}
                </div>
            </div>
            <div :span="8">
                <div v-for="(food, index) in foodData" :key="food.foodname" v-if="index<5">
                    ￥{{ food.price }}
                </div>
            </div>
            <div :span="3">
                <div v-for="(food, index) in foodData" :key="food.foodname" v-if="index<5">
                    {{ food.count }}份
                </div>
            </div>
            <div :span="4">
                <div v-for="(food, index) in foodData" :key="food.foodname" v-if="index<5">
                    ￥{{ food.sales }}
                </div>
            </div>

        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-top: 2%;

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
    import echarts from 'echarts'
    import differenceInDays from 'date-fns/difference_in_days'
    import addDays from 'date-fns/add_days'


    export default {
        mounted() {


        },
        data() {
            return {
                queryData: null,
                foodData: [],
            };
        },

        methods: {
            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                    food: this.food,
                };


                axios.get('/api/sales/foodSalesPackage', {
                    params: queryData
                })
                    .then(response => {
                        this.queryData = null;
                        this.foodData = [];
                        this.foodData = response.data;

                    }).catch(function (error) {
                    console.log(error);
                });

            },

        },

        watch: {
            date: function () {
                this.postData();
            },
            food: function () {
                this.postData();
            }
        },


        props: {
            'date': {
                required: false
            },
            'food': {
                required: false
            }
        },


    }
</script>
