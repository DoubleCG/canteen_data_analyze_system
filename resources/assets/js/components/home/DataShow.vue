<template>
    <div>
        <div :span="12" class="moneyOverView">
            <money-over-view></money-over-view>
        </div>
<!--         <div :span="12" class="todayClient">
                <today-client></today-client>
            </div> -->
        <div :span="12" class="weekFinance">
            <week-finance></week-finance>
        </div>
        <div :span="12" class="payType">
            <!-- <pay-type></pay-type> -->
        </div>
    </div>


</template>

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
        width: 20%;
        color: #FFFFFF;
        font-size: 18px;
    }

    .moneyOverView {
    }

    .payType {

    }

    .weekFinance {

    }

    .todayClient {

    }

    .firstRow {
        margin-top: 3%;
        margin-bottom: 3%;
    }

    .secondRow {
        margin-top: 3%;
        margin-bottom: 3%;
    }
</style>

<script>
    import MoneyOverView from './datashow/MoneyOverView';
    import PayType from './datashow/PayType';
    import TodayClient from './datashow/TodayClient';
    import WeekFinance from './datashow/WeekFinance';

    export default {
        components: {
            MoneyOverView,
            PayType,
            TodayClient,
            WeekFinance
        }
    }
</script>
