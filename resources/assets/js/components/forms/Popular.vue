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
            <div :span="5">
<!--                 <el-radio-group v-model="type" @change="pickType">
                    <el-radio label="price">价钱组合</el-radio>
                    <el-radio label="plate">盘子组合</el-radio>
                </el-radio-group> -->
            </div>
            <div :span="2">
                <button @click="postData" type="primary" :disabled="disableBtnQuery" :loading="loadBtnQuery">
                    查询
                </button>
            </div>
            <div :span="4">
                <button @click="exportData" type="primary" :disabled="disableBtnExport" :loading="loadBtnExport">
                    导出
                </button>
                <a id="downlink"></a>
            </div>
        </div>
        <div>
<!--             <data-tables :data="tableData" :search-def="{show:false}" :table-props="tableProps">
                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.label" sortable="custom">
                </el-table-column>
            </data-tables> -->
        </div>

    </div>


</template>

<style scoped>
    .div{
        margin-left: 20px;
        margin-bottom: 20px;
    }

</style>

<script>
    import xlsx_fontend from '../../helpers/xlsx_fontend'
    import xlsx_backend from '../../helpers/xlsx_backend'

    export default {
        mounted() {
            document.title = "最受欢迎";
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
                type: 'price',
                loadingQuery: false,
                loadingExport: false,
                tableData: [],
                titles: [
                    {
                        prop: "combine",
                        label: "套餐(单价*数量)",
                    },
                    {
                        prop: "count",
                        label: "交易量",
                    }
                ],
                tableProps: {
                    'show-summary': true,
                },
                timePick: '',
                label: '',
                queryData: '',
                count: '',

            };
        },
        methods: {
            Picktime: function (timePick) {
                this.timePick = timePick;
                timePick = _.words(timePick, /[^ ]+/g);
                this.timeStart = timePick[0];
                this.timeEnd = timePick[2];
            },
            pickType: function (label) {
                switch (label){
                    case 'price':
                        this.label = '价钱组合';
                        this.titles= [
                        {
                            prop: "combine",
                            label: "套餐(单价*数量)",
                        },
                        {
                            prop: "count",
                            label: "交易量",
                        }
                        ];
                        break;
                    case 'plate':
                        this.label = '盘子组合';
                        this.titles= [
                            {
                                prop: "combine",
                                label: "套餐(餐盘*数量)",
                            },
                            {
                                prop: "count",
                                label: "交易量",
                            }
                        ];
                        break;
                }
            },
            postData: function (){
                this.loadingQuery = true;
                this.queryData = {
                    timeStart: this.timeStart,
                    timeEnd: this.timeEnd,
                    type: this.type,
                    num: window.localStorage.getItem('device'),
                },
                axios.post('/api/popular', this.queryData)
                    .then(response => {
                        this.tableData = response.data;
                        this.count = _.size(response.data);
                        this.loadingQuery = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            exportData: function () {
                this.loadingExport = true;

                let fileName = this.timePick + '最受欢迎的' + this.label;
                if (this.count <= 10000) {
                    xlsx_fontend.downloadExl(this.titles, this.tableData, fileName, 'xlsx')
                } else
                {
                    this.$message('数据量较大，请不要关闭浏览器');
                    xlsx_backend.downloadExl(this.titles, this.tableData, 'Popular', fileName, 'xlsx');
                }


                this.loadingExport = false;
            },

        },
        computed: {
            disableBtnQuery: function(){
                if(this.timeStart && this.timeEnd && this.type){
                    return false;
                }else{
                    return true;
                }
            },
            disableBtnExport: function () {
                if(this.tableData.length == 0)
                {
                    return true;
                }
                else{
                    return false;
                }
            },
            loadBtnExport: function () {
                return this.loadingExport;
            },
            loadBtnQuery: function(){
                return this.loadingQuery;
            }
        },
    }
</script>
