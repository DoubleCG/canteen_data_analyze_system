<template>
    <div>
        <div>
<!--             <el-form :inline="true" class="demo-form-inline">
                <el-form-item>
                    <el-date-picker
                            v-model="date"
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
                    <el-button type="primary" @click="propsDate">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button @click="exportExcel" type="primary" icon="el-icon-download">导出</el-button>

                </el-form-item>
            </el-form> -->

        </div>
        <div>
<!--             <div :span="12">
                <el-select v-model="food" filterable placeholder="请选择">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </div> -->
        </div>


        <div>

            <div :span="12">

                <div>
                    <basic-info :date="dateForSearch" :food="foodForSearch"></basic-info>
                </div>
                <div>
                    <history :date="dateForSearch" :food="foodForSearch"></history>
                </div>


            </div>
            <div :span="12">

                <history-detail :date="dateForSearch" :food="foodForSearch"></history-detail>

            </div>

        </div>
        <div>
            <best-partner :date="dateForSearch" :food="foodForSearch"></best-partner>
        </div>


    </div>
</template>


<style scoped>

</style>


<script>
    import basicInfo from './BasicInfo'
    import bestPartner from './BestPartner'
    import history from './History'
    import historyDetail from './HistoryDetail'

    // import addDays from 'date-fns/add_days'
    // import format from 'date-fns/format'

    export default {
        mounted() {
            axios.get('/api/allFood')
                .then(response => {
                    this.options = response.data;
                    this.food = response.data[0].value;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        data() {

            return {
                date: null,
                dateForSearch: null,
                food: null,
                foodForSearch: null,
                options: null,
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
            }

        },


        methods: {
            propsDate() {
                let date = [];

                date[0] = format(date[0]);
                date[1] = format(date[1]);
                date[1] = addDays(date[1], 1);
                this.dateForSearch = this.date;
                this.foodForSearch = this.food;
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
                console.log(date);
                let queryData = {
                    timeStart: date[0],
                    timeEnd: date[1],
                    food: this.food,
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

                axios.get('/api/salesSearchData', {
                    params: queryData,
                    responseType: 'arraybuffer',
                }).then(response => {
                    let blob = new Blob([response.data], {type: 'application/msexcel'});
                    let href = URL.createObjectURL(blob);  // 创建对象超链接
                    let outFile = document.createElement('a');
                    outFile.download = '菜品销量查询' + date[0] + '-' + date[1] + '.' + 'xls';  // 下载名称
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


        components: {
            basicInfo,
            bestPartner,
            history,
            historyDetail
        },
    }
</script>
