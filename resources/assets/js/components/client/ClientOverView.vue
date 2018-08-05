<template>
    <div class="news">
        <div class="title">
            客流基本信息
        </div>
        <div>
            <div class="chart">
                <p>
                    客流总量 {{ allClient }} 人次
                </p>
                <p>
                    平均客流量 {{ clientPreMin }} 人次/分钟
                </p>
            </div>
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
        height: 100px !important;
    }
</style>

<script>
    import echarts from 'echarts'

    var differenceInMinutes = require('date-fns/difference_in_minutes')

    export default {
        mounted() {

        },

        methods: {

            cleanData() {
                this.allClient = 0;
                this.clientPreMin = 0;
            },


            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };


                axios.get('/api/finance/orderNum', {
                    params: queryData
                })
                    .then(response => {
                        this.allClient = response.data[0].count;
                    }).catch(function (error) {
                    console.log(error);
                });


                axios.get('/api/avClient', {
                    params: queryData
                })
                    .then(response => {
                        let avCount = 0;
                        console.log(response);
                        for (let i = 0; i < _.size(response.data); i++) {
                            avCount = avCount + response.data[i].count;
                        }
                        console.log(avCount);
                        this.clientPreMin = Math.round(avCount / (5 * _.size(response.data)));
                    }).catch(function (error) {
                    console.log(error);
                });


            }
        },


        data() {
            return {
                allClient: null,
                clientPreMin: null,

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
