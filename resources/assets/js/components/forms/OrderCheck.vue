<template>
    <div>
        <div type="flex" align="middle">
            <div :span="6">
<!--                 <el-date-picker
                        v-model="time"
                        type="daterange"
                        align="right"
                        placeholder="选择日期范围"
                        @change="Picktime"
                        :picker-options="pickerOptions2">
                </el-date-picker> -->
            </div>
            <div :span="8" :offset="1">
                <button @click="postData" type="primary" :disabled="disableBtn" :loading="loadBtn">查询</button>
            </div>
        </div>
        <div>
<!--             <data-tables @current-change="handleCurrentChange" :data="dataTable1" :search-def="searchDef"
                         :table-props="tableProps1">
                <el-table-column v-for="title in titles1" :prop="title.prop" :label="title.label" :key="title.label"
                                 :sortable="false">
                </el-table-column>
            </data-tables> -->
        </div>
        <div>
<!--             <el-table :data="dataTable2" :search-def="{show:false}" :table-props="tableProps2">
                <el-table-column v-for="title in titles2" :prop="title.prop" :label="title.label" :key="title.label"
                                 sortable="custom">
                </el-table-column>
            </el-table> -->
        </div>

    </div>


</template>

<style scoped>
    .el-row {
        margin-left: 20px;
        margin-bottom: 20px;
    }

</style>

<script>

    export default {
        mounted() {
            document.title = "订单查询";
        },
        data() {
            return {
                pickerOptions2: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
                time: '',
                timeStart: '',
                timeEnd: '',
                loading: false,
                dataTable1: [],
                dataTable2: [],
                dataTmp: [],
                titles1: [
                    {
                        prop: "id",
                        label: "编号",
                    },
                    {
                        prop: "clientid",
                        label: "设备编号",
                    },
                    {
                        prop: "orderid",
                        label: "订单号",
                    },
                    {
                        prop: "date",
                        label: "时间",
                    },
                    {
                        prop: "money",
                        label: "金额",
                    },
                ],
                titles2: [
                    {
                        prop: "id",
                        label: "编号",
                    },
                    {
                        prop: "price",
                        label: "金额",
                    },
                    {
                        prop: "count",
                        label: "数量",
                    },
                    {
                        prop: "dishname",
                        label: "餐具名称",
                    },
                ],
                input: '',
                tableProps2: {
                    'show-summary': true,
                },
                tableProps1: {
                    'height': 250,
                    'highlight-current-row': true,
                },
                searchDef: {
                    show: true,
                    colProps: {
                        span: 5,
                        offset: 19
                    }

                },


            };
        },
        methods: {
            Picktime: function (timePick) {
                timePick = _.words(timePick, /[^ ]+/g);
                this.timeStart = timePick[0];
                this.timeEnd = timePick[2];
            },
            postData: function () {
                this.loading = true;
                axios.post('/api/orderCheck', {
                    timeStart: this.timeStart,
                    timeEnd: this.timeEnd,
                    orderid: this.input,
                    num: window.localStorage.getItem('device'),
                })
                    .then(response => {
                        this.dataTable1 = response.data.data1;
                        this.dataTmp = response.data.data2;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            handleCurrentChange: function (currentRow) {
                let id = currentRow.id;
                this.dataTable2 = this.dataTmp[id];
            }
        },
        computed: {
            disableBtn: function () {
                if (this.time) {
                    return false;
                } else {
                    return true;
                }
            },
            loadBtn: function () {
                return this.loading;
            }
        },
    }
</script>
