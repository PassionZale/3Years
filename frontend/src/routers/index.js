import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '../components/layouts/Index.vue'

Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const RouterMap = [
    { 
        path: '/', 
        component: Layout,
        redirect: '/home',
        children: [
            { path: 'home', name: '首页', component: _import('Home') },
            { path: 'category', name: '分类', component: _import('Category') },
            { path: 'cart', name: '购物车', component: _import('Cart') },
            { path: 'user', name: '用户中心', component: _import('UserCenter') },
        ] 
    },
    { path: '/search', name: '搜索商品', component: _import('Search') },
    { path: '*', name: '404', component: _import('404') },
];

export default new VueRouter({
    mode: 'hash',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap,
});