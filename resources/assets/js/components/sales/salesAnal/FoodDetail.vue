<template>
    <div class="news">
 <!--        <el-table fit fixed :data="tableData" height="700">
            <i class="el-icon-download"></i>
            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label">
            </el-table-column>
        </el-table> -->
    </div>
</template>

<style scoped>
    .news {
        margin-right: 1%;
        margin-bottom: 2%;
    }



</style>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                tableData: [],
                titles: [
                    {
                        prop: "foodname",
                        label: "菜品名称",
                    },
                    {
                        prop: "price",
                        label: "单价",
                    },
                    {
                        prop: "count",
                        label: "销量",
                    },
                    {
                        prop: "money",
                        label: "营业额",
                    }],

            };
        },

        methods: {
            postData() {
                this.tableData = [];

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };

                axios.get('/api/sales/popularFood', {
                    params: queryData
                })
                    .then(response => {
                        this.tableData = response.data;
                    }).catch(function (error) {
                    console.log(error);
                });




            }
        },

        watch: {
            date: function () {
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
