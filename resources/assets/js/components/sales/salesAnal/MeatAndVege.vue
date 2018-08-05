<template>
    <div class="news">
        <div class="title"> 荤素营业额TOP5 </div>
        <div>
            <div :span="10" class="leftPart">
                <div class="subTitle">荤菜TOP5</div>

                <div :span="5" :offset="1">
                    <div class="littleTitle">菜品名称</div>
                    <div v-for="(food, index) in meatData" :key="food.dishname" v-if="index<5 ">
                        {{ food.dishname }}
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">单价</div>
                    <div v-for="(food, index) in meatData" :key="food.dishname" v-if="index<5">
                        ￥{{ food.Name }}
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">销量</div>
                    <div v-for="(food, index) in meatData" :key="food.dishname" v-if="index<5">
                        {{ food.count }}份
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">营业额</div>
                    <div v-for="(food, index) in meatData" :key="food.dishname" v-if="index<5">
                        ￥{{ food.sales }}
                    </div>
                </div>
            </div>


            <div :span="14">
                <div class="subTitle">素菜TOP5</div>

                <div :span="5" :offset="1">
                    <div class="littleTitle">菜品名称</div>
                    <div v-for="(food, index) in vegeData" :key="food.dishname" v-if="index<5">
                        {{ food.dishname }}
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">单价</div>
                    <div v-for="(food, index) in vegeData" :key="food.dishname" v-if="index<5">
                        ￥{{ food.Name }}
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">销量</div>
                    <div v-for="(food, index) in vegeData" :key="food.dishname" v-if="index<5">
                        {{ food.count }}份
                    </div>
                </div>
                <div :span="6">
                    <div class="littleTitle">营业额</div>
                    <div v-for="(food, index) in vegeData" :key="food.dishname" v-if="index<5">
                        ￥{{ food.sales }}
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<style scoped>
    .news {
        border: solid 1px #e6e6e6;
        border-radius: 20px;
        margin-right: 1%;
        margin-bottom: 3%;

    }

    .title {
        margin: -10px auto 0;
        text-align: center;
        border: solid 1px #888888;
        border-radius: 20px;
        background-color: #888888;
        width: 30%;
        color: #FFFFFF;
        font-size: 18px;
    }


    .subTitle{
        font-size: 20px;
        text-align: center;
        font-weight: bold;
    }


    .leftPart{
        border-right-style: solid;
        border-right-width: 1px;
        margin-bottom: 3%;

    }

    .littleTitle{
        margin-bottom: 5%;

    }

</style>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                meatData: [],
                vegeData: [],
            };
        },

        methods: {
            postData() {

                let queryData = {
                    timeStart: this.date[0],
                    timeEnd: this.date[1],
                    device: window.localStorage.getItem('device'),
                };

                axios.get('/api/meatAndVege', {
                    params: queryData
                })
                    .then(response => {
                        this.meatData = [];
                        this.vegeData = [];
                        for(let i = 0; i < _.size(response.data); i++){
                            if(response.data[i].attributes == 'vege'){
                                this.vegeData.push(response.data[i]);
                            }
                            if(response.data[i].attributes == 'meat' || response.data[i].attributes == 'meat-vege'){
                                this.meatData.push(response.data[i]);
                            }
                        }
                        console.log(this.vegeData);

                        console.log(this.meatData);
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
