import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const RouterMap = [
    { path: '/', component: _import('Index') },
    { path: '/login', component: _import('Login') },
    { path: '/detail', component: _import('Detail') },
    { path: '/404', component: _import('404') },
];

export default new VueRouter({
    mode: 'history',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap
});