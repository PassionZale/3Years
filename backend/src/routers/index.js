import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const RouterMap = [
    { path: '/login', name: '登录', component: _import('auth/Login') },
    { path: '/superuser', name: '超级用户', component: _import('auth/Superuser') },
    {
        path: '/',
        component: _import('dashboard/BaseLayout'),
        redirect: '/dashboard',
        children: [
            { path: 'dashboard', name: '首页', component: _import('dashboard/Dashboard') },
            { path: 'user', name: '用户', component: _import('dashboard/User') },
            { path: 'follow', name: '粉丝', component: _import('dashboard/Follow') },
            { path: 'product', name: '商品', component: _import('dashboard/Product') },
        ]
    },
    { path: '*', name: '404', component: _import('404') },
];

export default new VueRouter({
    mode: 'history',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap
});