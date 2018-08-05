<template>
    <div>
        <div>
<!--             <el-form :inline="true" class="demo-form-inline">
                <el-form-item>
                    <el-date-picker
                            v-model="time"
                            align="right"
                            type="date"
                            placeholder="选择日期"
                            value-format="yyyy-MM-dd"
                            :picker-options="pickerOptions1">
                    </el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="postData">查询</el-button>
                </el-form-item>
            </el-form> -->
            <div class="news">
                <div class="title">
                    单品销量
                </div>
                <div class="content">
                    <!-- <chart class="chart" :options="formData" @click="chartClick"></chart> -->
                </div>
            </div>
            <div class="news" >
                <div class="title">
                    单品详细销量
                </div>
                <div class="content">
                    <!-- <chart class="chart" :options="dishchartData"></chart> -->
                </div>
            </div>
        </div>


        <div>
            <!--<data-tables :data="tableData" :search-def="{show:false}" :table-props="tableProps">-->
            <!--<el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label" sortable="custom">-->
            <!--</el-table-column>-->
            <!--</data-tables>-->
        </div>

    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
    }

    .div {
        margin-bottom: 2%;
    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #20a0ff;
        border-radius: 20px;
        background-color: #20a0ff;
        width: 20%;
        color: #FFFFFF;
        font-size: 18px;
        margin-bottom: 2%;
    }

    .chart {
        width: calc(100%) !important;
        height: 400px !important;
    }
</style>

<script>

    import echarts from 'echarts'

    export default {
        mounted() {
//            axios.get('/api/dishName', {})
//                .then(response => {
//                    this.options = response.data;
//                })
//                .catch(function (error) {
//                    console.log(error);
//                });
//            document.title = "菜品销量分析";
        },
        data() {
            return {
                pickerOptions1: {
                    shortcuts: [{
                        text: '今天',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: '昨天',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '一周前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                },
                time: '',
                dish: '',
                loading: false,
                allDishData: [],
                allDishName: [],
                allDishSale: [],
                dishData: [],
                queryData2: [],
                dishchartData: null,
                dishchartTime: [],
                dishChartValue: [],
                formData: null,
                titles: [
                    {
                        prop: "clientid",
                        label: "设备编号",
                    },
                    {
                        prop: "time",
                        label: "时间",
                    },
                    {
                        prop: "count",
                        label: "数量",
                    },],
                options: [],
                tableProps: {
                    'show-summary': true,
                },
                loadingExport: false,
                queryData: '',
                count: '',

            };
        },
        methods: {

            postData: function () {
                console.log(this.time);
                this.allDishData = null;
                this.allDishName = [];
                this.allDishSale = [];
                this.loading = true;
                this.queryData = {
                    time: this.time,
                    num: window.localStorage.getItem('device'),
                };
                axios.get('/api/allDishSales', {
                    params: this.queryData
                })
                    .then(response => {
                        this.allDishData = response.data;
                        console.log(this.allDishData);
                        for (var index in response.data) {
                            if (index != 0) {
                                this.allDishName.push(response.data[index].dishname);
                                this.allDishSale.push(response.data[index].count);
                            }

                        }
                        this.formData = {
                            tooltip: {
                                trigger: 'axis'
                            },
                            grid: {
                                left: '0%',
                                right: '5%',
                                containLabel: true
                            },
                            toolbox: {
                                right: '10%',
                                show: true,
                                feature: {
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            xAxis: [
                                {
                                    type: 'category',
                                    data: this.allDishName,
                                }
                            ],
                            yAxis: [
                                {
                                    type: 'value',
                                    name: '交易量',
                                    position: 'left',
                                    axisLabel: {
                                        formatter: '{value} 件',
                                    }
                                },
                            ],
                            series: [
                                {
                                    name: '销量',
                                    type: 'bar',
                                    data: this.allDishSale
                                },
                            ]
                        };


                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            exportData: function () {
                this.loadingExport = true;

                let fileName = this.time + this.dish + '销量分析';
                if (this.count <= 10000) {
                    xlsx_fontend.downloadExl(this.titles, this.tableData, fileName, 'xlsx')
                } else {
                    this.$message('数据量较大，请不要关闭浏览器');
                    xlsx_backend.downloadExl(this.titles, this.tableData, 'Sales', fileName, 'xlsx');
                }

                this.loadingExport = false;
            },
            chartClick: function (chartData) {
                this.dishchartData = null;
                this.dishchartTime = [];
                this.dishChartValue = [];
                console.log(chartData.name);
                this.queryData2 = {
                    time: this.time,
                    dish: chartData.name,
                    num: window.localStorage.getItem('device')
                };
                console.log(this.queryData2);
                axios.get('/api/dishSales', {
                    params: this.queryData2
                })
                    .then(response => {
                        console.log(response.data)
                        for (var index in response.data) {

                            this.dishchartTime.push(response.data[index].time);
                            this.dishChartValue.push(response.data[index].count);


                        }



                        this.dishchartData = {
                            toolbox: {
                                right: '10%',
                                show: true,
                                feature: {
                                    saveAsImage: {show: true}
                                }
                            },
                            grid: {
                                left: '0%',
                                right: '5%',
                                containLabel: true
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'cross'
                                }
                            },

                            xAxis: [
                                {
                                    type: 'category',
                                    axisTick: {
                                        alignWithLabel: true
                                    },
                                    axisLine: {
                                        onZero: false,
                                    },
                                    data: this.dishchartTime,
                                },
                            ],
                            yAxis: [
                                {
                                    type: 'value',
                                    name: '交易量',
                                    position: 'left',
                                    axisLabel: {
                                        formatter: '{value} 件',
                                    }
                                },
                            ],
                            series: [

                                {
                                    name: '交易量',
                                    type: 'line',
                                    smooth: true,
                                    data: this.dishChartValue,
                                }
                            ]
                        }

                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
        },
        computed: {
            disableBtn: function () {
                if (this.time && this.dish) {
                    return false;
                } else {
                    return true;
                }
            },
            loadBtn: function () {
                return this.loading;
            },
            disableBtnExport: function () {
                if (this.tableData.length == 0) {
                    return true;
                }
                else {
                    return false;
                }
            },
            loadBtnExport: function () {
                return this.loadingExport;
            },
        },
    }
</script>
