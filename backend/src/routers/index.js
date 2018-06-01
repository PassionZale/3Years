import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '../components/layouts/Index.vue'
import systemRouter from './dynamic/systemRouter'
import productRouter from './dynamic/productRouter'
import shopRouter from './dynamic/shopRouter'
import wechatRouter from './dynamic/wechatRouter'


Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const RouterMap = [
    { path: '/login', name: '登录', component: _import('auth/Login') },
    { path: '/superuser', name: '超级用户', component: _import('auth/Superuser') },
    {
        path: '/',
        component: Layout,
        redirect: '/console',
        children: [
            { path: 'console', name: '首页', component: _import('console/Index') },
            { path: 'user', name: '个人中心', component: _import('user/Index') },
            // dynamic router list
            systemRouter,
            productRouter,
            shopRouter,
            wechatRouter,
        ]
    },
    { path: '*', name: '404', component: _import('404') },
];

export default new VueRouter({
    mode: 'hash',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap
});