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
            <div>
                <!-- <popular-top5 :date="dateForSearch"></popular-top5> -->
            </div>
        </div>


        <div>

            <el-col :span="24">


                <div>
                    <meat-and-vege :date="dateForSearch"></meat-and-vege>
                </div>
                <div>
                    <plate-price :date="dateForSearch"></plate-price>
                </div>


            </el-col>


        </div>
        <div>


            <el-col :span="24">
                <food-detail :date="dateForSearch"></food-detail>
            </el-col>
        </div>


    </div>
</template>


<style scoped>

</style>


<script>
    import foodDetail from './foodDetail';
    import meatAndVege from './meatAndVege';
    import platePrice from './platePrice';
    import popularTop5 from './popularTop5'

    import addDays from 'date-fns/add_days'
    import format from 'date-fns/format'

    export default {
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
            }

        },


        methods: {
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
                });                let date = [];
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

                axios.get('/api/salesAnalData', {
                    params: queryData,
                    responseType: 'arraybuffer',
                }).then(response => {
                    let blob = new Blob([response.data], {type: 'application/msexcel'});
                    let href = URL.createObjectURL(blob);  // 创建对象超链接
                    let outFile = document.createElement('a');
                    outFile.download = '菜品销量分析' + date[0] + '-' + date[1] + '.' + 'xls';  // 下载名称
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
            foodDetail,
            meatAndVege,
            platePrice,
            popularTop5
        },
    }
</script>
