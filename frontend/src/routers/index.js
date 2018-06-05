import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const RouterMap = [
    { path: '/', name: '首页', component: _import('Index') },
    { path: '*', name: '404', component: _import('404') },
];

export default new VueRouter({
    mode: 'hash',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap
});