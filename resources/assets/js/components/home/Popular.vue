<template>
    <div class="news">
        <div class="title"> 最受欢迎TOP3 </div>
        <div class="content">
            <div :span="9" class="number">
                <div>
                    单品TOP3
                </div>
                <div class="single">
                    <div :data="singleData" style="width: 100%" :show-header="false">
                        <div prop="dish" label="菜品">
                        </div>
                        <div prop="money" label="价格" width="70">
                        </div>
                        <div prop="count" label="数量" width="70">
                        </div>
                    </div>
                </div>
            </div>
            <div :span="15">
                <div>
                    套餐TOP3
                </div>
                <div class="multiple">
                    <div :data="multipleData" style="width: 100%" :show-header="false">
                        <div prop="combine" label="菜品">
                        </div>
                        <div prop="money" label="价格" width="70">
                        </div>
                        <div prop="count" label="数量" width="70">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>

    export default {
        mounted() {
            let isTest = true;
            if(isTest){
                axios.get('/api/test')
                .then(response=>{
                    console.log(response);
                })
                .catch(error=>{
                    console.log(error);
                });
            }else{
                axios.get('/api/home/singlePopular')
                .then(response => {
                    console.log(response);
                    for (let i = 0; i < _.size(response.data); i++) {
                        response.data[i].money = '￥' + response.data[i].money;
                        response.data[i].count = response.data[i].count + '份';
                    }
                    this.singleData = response.data;
                })
                .catch(function (error) {
                    console.log('axios.get(/api/home/singlePopular)');
                    console.log(error);
                    let singleData = [];
                    for(let i=0;i<50;i++){
                        singleData.push({
                            dish:'dsfa',
                            money:'￥'+parseInt(Math.random()*100),
                            count:parseInt(Math.random()*100)+'份'
                        })
                    }
                    this.singleData = singleData;
                });

            // axios.get('/api/home/multiplePopular')
            //     .then(response => {
            //         for (let i = 0; i < _.size(response.data); i++) {
            //             response.data[i].money = '￥' + response.data[i].money;
            //             response.data[i].count = response.data[i].count + '份';
            //         }
            //         this.multipleData = response.data;
            //     })
            //     .catch(error=>{
            //         console.log(error);
            //     });
            }



        },
        data() {
            return {
                singleData: [],
                multipleData: [],
            };
        },


    }
</script>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #20a0ff;
        border-radius: 20px;
        background-color: #20a0ff;
        width: 30%;
        color: #FFFFFF;
        font-size: 18px;
        margin-bottom: 2%;
    }

    .single {
        margin-left: 2%;
        margin-right: 2%;
    }

    .number {
        border-right: solid 1px #e6e6e6;
    }
    .el-table td, .el-table th.is-leaf {
        border-bottom: 0px solid #e6ebf5 !important;
    }

    .multiple {
        margin-left: 2%;
        margin-right: 2%;
    }

    .content {
        margin-bottom: 2%;
    }


</style>
