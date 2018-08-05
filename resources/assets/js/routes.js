import VueRouter from 'vue-router'
import Store from './store'
// import JWTToken from './helpers/JWT'


let routes = [
    // {
    //     path: '/login',
    //     name: 'login',
    //     component: require('./components/pages/Login'),
    //     mete: {requireAuth: false}
    // },
    // {
    //     path: '/',
    //     name: 'home',
    //     component: require('./components/pages/Home'),
    //     meta: {requireAuth: true}
    // },
    {
        path: '/client',
        name: 'client',
        component: require('./components/client/Client'),
        meta: {requireAuth: true},
    },
    {
        path: '/clientOverView',
        name: 'clientOverView',
        component: require('./components/client/ClientOverView'),
        meta: {requireAuth: true},
    },
    {
        path: '/clientFre',
        name: 'clientFre',
        component: require('./components/client/ClientFre'),
        meta: {requireAuth: true},
    },
    {
        path: '/history',
        name: 'history',
        component: require('./components/client/History'),
        meta: {requireAuth: true},
    },

    {
        path: '/finance',
        name: 'finance',
        component: require('./components/finance/Finance'),
        meta: {requireAuth: true},
    },

    {
        path: '/moneyOverView',
        name: 'moneyOverView',
        component: require('./components/finance/MoneyOverView'),
        meta: {requireAuth: true},
    },
    {
        path: '/orderMoney',
        name: 'orderMoney',
        component: require('./components/finance/OrderMoney'),
        meta: {requireAuth: true},
    },

    {
        path: '/payType',
        name: 'payType',
        component: require('./components/finance/PayType'),
        meta: {requireAuth: true},
    },

    {
        path: '/salesData',
        name: 'salesData',
        component: require('./components/finance/SalesData'),
        meta: {requireAuth: true},
    },


    {
        path: '/orderCheck',
        name: 'orderCheck',
        component: require('./components/forms/OrderCheck'),
        meta: {requireAuth: true}
    },
    {
        path: '/orderDetial',
        name: 'orderDetial',
        component: require('./components/forms/OrderDetail'),
        meta: {requireAuth: true}
    },
     {
        path: '/popular',
        name: 'popular',
        component: require('./components/forms/Popular'),
        meta: {requireAuth: true}
    },
    {
        path: '/sales',
        name: 'sales',
        component: require('./components/forms/Sales'),
        meta: {requireAuth: true}
    },

    {
        path: '/sales',
        name: 'sales',
        component: require('./components/sales/Sales'),
        meta: {requireAuth: true},
        children: [
            {
                path: '',
                name: '',
                component: require('./components/sales/salesAnal/SalesAnal'),
                meta: {requireAuth: true},

            },
            {
                path: 'salesAnal',
                name: 'salesAnal',
                component: require('./components/sales/salesAnal/SalesAnal'),
                meta: {requireAuth: true},

            },
            {
                // 当 /user/:id/posts 匹配成功
                // UserPosts 会被渲染在 User 的 <router-view> 中
                path: 'salesSearch',
                name: 'salesSearch',
                component: require('./components/sales/salesSearch/SalesSearch'),
                meta: {requireAuth: true},

            }
        ]
    },

];

const router = new VueRouter({
    mode: 'history',
    routes
});

// router.beforeEach((to, from, next) => {s

//     if (to.meta.requireAuth) {
//         if (Store.state.AuthUser.authenticated || JWTToken.getToken()) {
//             return next();
//         } else {
//             return next('/login');
//         }
//     }

//     if (!to.meta.requireAuth) {

//         if (Store.state.AuthUser.authenticated || JWTToken.getToken()) {
//             return next('/');
//         } else {
//             return next();
//         }
//     }
//     return next();
// })

export default router;
