<template>
    <div>
        <div>
<!--             <el-form :inline="true" class="demo-form-inline">
                <el-form-item>
                    <el-date-picker
                            v-model="time"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            format="yyyy 年 MM 月 dd 日"
                            :picker-options="pickerOption">
                    </el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="postData">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button @click="exportExcel" type="primary" icon="el-icon-download">导出</el-button>
                </el-form-item>
            </el-form> -->
        </div>

        <div>
<!--             <el-table fit :data="tableData" v-loading="loading"
                      :span-method="objectSpanMethod"
            >
                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label">
                </el-table-column>

            </el-table> -->
        </div>
        <div class="pageshow">
 <!--            <el-pagination
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-size="20"
                    layout="total, prev, pager, next, jumper"
                    :total="total">
            </el-pagination> -->

        </div>
        <div v-show="false" @click="gotop" class="page-component-up">
            <i @click="gotop" class="el-icon-caret-top"></i>
        </div>
    </div>


</template>

<style scoped>
    .pageshow {
        margin-top: 2%;
        text-align: center;
    }

    .div {
    }

    .page-component-up {
        background-color: #fff;
        position: fixed;
        right: 100px;
        bottom: 150px;
        width: 40px;
        height: 40px;
        border-radius: 20px;
        cursor: pointer;
        transition: .3s;
        box-shadow: 0 0 6px rgba(0, 0, 0, .12);
    }

    .el-icon-caret-top {
        color: #409eff;
        display: block;
        line-height: 40px;
        text-align: center;
        font-size: 18px;
    }

</style>

<script>
    import addDays from 'date-fns/add_days'
    import format from 'date-fns/format'

    export default {
        mounted() {
            document.title = "订单明细";
            $(window).on('scroll', function(){
                if ($(this).scrollTop() > 50) {
                    $('.page-component-up').fadeIn()
                } else {
                    $('.page-component-up').fadeOut()
                }
            })
        },
        data() {
            return {
                spanData: [],
                total: 0,
                pickerOption: {
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
                    }]
                },
                time: '',
                tempid: '123',
                loading: false,
                tableData: [],
                titles: [
                    {
                        prop: "orderid",
                        label: "编号",
                    },
                    {
                        prop: "clientid",
                        label: "设备编号",
                    },
                    {
                        prop: "date",
                        label: "日期",
                    },
                    {
                        prop: "time",
                        label: "时间",
                    },
                    {
                        prop: "money",
                        label: "总价",
                    },
                    {
                        prop: "item",
                        label: "餐具名称",
                    },
                    {
                        prop: "price",
                        label: "单价",
                    },
                    {
                        prop: "count",
                        label: "数量",
                    },
                    {
                        prop: "pay",
                        label: "支付方式",
                    },],
                loadingExport: false,
                timePick: '',
                count: '',
                queryData: '',
                downloading: '',

                currentPage: 1,

            };
        },
        methods: {
            gotop() {
                $('body,html').animate({ scrollTop: 0 }, 800)
            },
            objectSpanMethod({row, column, rowIndex, columnIndex}) {
                if (columnIndex < 5 || columnIndex == 8) {
                    if (this.spanData[rowIndex] != 0) {
                        return {
                            rowspan: this.spanData[rowIndex],
                            colspan: 1
                        }
                    }
                    else {
                        return {
                            rowspan: 0,
                            colspan: 0
                        }
                    }

                }
            },
            postData: function () {
                this.loading = true;

                let date = [];
                date[0] = format(this.time[0]);
                date[1] = format(this.time[1]);
                date[1] = addDays(this.time[1], 1);


                this.queryData = {
                    timeStart: date[0],
                    timeEnd: date[1],
                    num: window.localStorage.getItem('device'),
                };
                axios.get('/api/orderDeital', {
                    params: this.queryData
                })
                    .then(response => {
                        console.log(response.data);
                        this.tableData = response.data.data;
                        this.total = response.data.total;
                        this.spanData = [];
                        for (var i = 0; i < _.size(this.tableData); i++) {
                            if (i == 0 || this.tableData[i].orderid != this.tableData[i - 1].orderid) {
                                var count = 0;
                                for (var j = 0; j < _.size(this.tableData); j++) {
                                    if (this.tableData[j].orderid == this.tableData[i].orderid) {
                                        count++;
                                    }
                                }
                                this.spanData.push(count);
                                for (var k = 0; k < count - 1; k++) {
                                    this.spanData.push(0);
                                }
                            }

                        }

                        console.log(this.spanData);
                        this.count = _.size(response.data);
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            exportExcel() {
                this.$message({
                    message: '请耐心等待，不要关闭浏览器',
                    center: true,
                    duration: 0,
                    type: 'warning',
                    showClose: true,
                });
                let date = [];
                date[0] = format(this.time[0]);
                date[1] = format(this.time[1]);
                date[1] = addDays(this.time[1], 1);
                console.log(date);
                let queryData = {
                    timeStart: date[0],
                    timeEnd: date[1],
                    device: window.localStorage.getItem('device'),
                };

                date[0] = format(
                    date[0],
                    'YYYYMMDD'
                );

                date[1] = format(
                    date[1],
                    'YYYYMMDD'
                );

                axios.get('/api/exportDetail', {
                    params: queryData,
                    responseType: 'arraybuffer',
                }).then(response => {
                    let blob = new Blob([response.data], {type: 'application/msexcel'});
                    let href = URL.createObjectURL(blob);  // 创建对象超链接
                    let outFile = document.createElement('a');
                    outFile.download = '订单明细' + date[0] + '-' + date[1] + '.' + 'xls';  // 下载名称
                    outFile.href = href; // 绑定a标签
                    outFile.click();  // 模拟点击实现下载
                    setTimeout(function () {  // 延时释放
                        URL.revokeObjectURL(blob); // 用URL.revokeObjectURL()来释放这个object URL
                    }, 100);
                    outFile.remove();
                    this.$message.closeAll();
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            handleCurrentChange(val) {
                this.loading = true;

                let date = [];
                date[0] = format(this.time[0]);
                date[1] = format(this.time[1]);
                date[1] = addDays(this.time[1], 1);


                this.queryData = {
                    timeStart: date[0],
                    timeEnd: date[1],
                    num: window.localStorage.getItem('device'),
                    page: val,
                };
                axios.get('/api/orderDeital', {
                    params: this.queryData
                })
                    .then(response => {
                        console.log(response.data);
                        this.tableData = response.data.data;
                        this.total = response.data.total;
                        this.spanData = [];
                        for (var i = 0; i < _.size(this.tableData); i++) {
                            if (i == 0 || this.tableData[i].orderid != this.tableData[i - 1].orderid) {
                                var count = 0;
                                for (var j = 0; j < _.size(this.tableData); j++) {
                                    if (this.tableData[j].orderid == this.tableData[i].orderid) {
                                        count++;
                                    }
                                }
                                this.spanData.push(count);
                                for (var k = 0; k < count - 1; k++) {
                                    this.spanData.push(0);
                                }
                            }

                        }


                        this.count = _.size(response.data);
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        computed: {
            disableBtn: function () {
                if (this.timeStart && this.timeEnd) {
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
