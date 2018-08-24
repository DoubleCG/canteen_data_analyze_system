<template>
    <div>
        <div>
            <div :inline="true" class="demo-form-inline">
                <div>
                    <div
                            v-model="date"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            format="yyyy 年 MM 月 dd 日"
                            :picker-options="pickerOption">
                    </div>
                </div>
                <div>
                    <button type="primary" @click="propsDate">查询</button>
                </div>
                <div>
                    <button @click="exportExcel" type="primary" icon="el-icon-download">导出</button>
                </div>
            </div>
        </div>

        <div class="news">

            <div class="secondRow">
                <div :span="12" class="weekFinance">
                    <div class="upperRow">
                        <client-over-view :date="dateForSearch"></client-over-view>
                    </div>
                    <div v-show="false">
                        <clinet-fre :date="dateForSearch"></clinet-fre>
                    </div>
                </div>
                <div :span="12" class="todayClient">
                    <history :date="dateForSearch"></history>
                </div>
            </div>

        </div>
        <div v-show="false" @click="gotop" class="page-component-up">
            <i @click="gotop" class="el-icon-caret-top"></i>
        </div>

    </div>
</template>


<script>
    import ClientOverView from './ClientOverView';
    import ClinetFre from './ClientFre';
    import History from './History';

    export default {
        mounted() {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 50) {
                    $('.page-component-up').fadeIn()
                } else {
                    $('.page-component-up').fadeOut()
                }
            })
        },
        components: {
            ClientOverView,
            ClinetFre,
            History
        },
        data() {
            return {
                date: null,
                dateForSearch: null,
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


                TotalMoney: null,
                data1: [],
                data2: [],
                chartData: null,
            };
        },

        methods: {
            gotop() {
                $('body,html').animate({scrollTop: 0}, 800)
            },
            propsDate() {
                let date = [];
                date[0] = format(this.date[0]);
                date[1] = format(this.date[1]);
                date[1] = addDays(this.date[1], 1);

                this.dateForSearch = date;
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
                date[0] = format(this.date[0]);
                date[1] = format(this.date[1]);
                date[1] = addDays(this.date[1], 1);
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

                axios.get('/api/exportSalesData', {
                    params: queryData,
                    responseType: 'arraybuffer',
                }).then(response => {
                    let blob = new Blob([response.data], {type: 'application/msexcel'});
                    let href = URL.createObjectURL(blob);  // 创建对象超链接
                    let outFile = document.createElement('a');
                    outFile.download = '客流情况' + date[0] + '-' + date[1] + '.' + 'xls';  // 下载名称
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
            }


        },


    }
</script>


<style scoped>
    .upperRow {

        margin-bottom: 2%;
    }

    .dataShow {
        margin-top: 3%;
        text-align: -webkit-center;

    }

    .news {
        text-align: -webkit-center;

    }

    .popular {
        text-align: -webkit-center;

    }

    .firstRow {
        margin-bottom: 2%;
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
