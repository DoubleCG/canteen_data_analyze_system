<template>
    <div class="news">
<!--         <el-table fit fixed :data="tableData" height="700">
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
                        prop: "date",
                        label: "消费时间",
                    },
                    {
                        prop: "id",
                        label: "订单号",
                    },
                    {
                        prop: "count",
                        label: "数量",
                    }],

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

                axios.get('/api/sales/foodSalesDetail', {
                    params: queryData
                })
                    .then(response => {
                        this.tableData = [];
                        this.tableData = response.data;
                    }).catch(function (error) {
                    console.log(error);
                });


            }
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
