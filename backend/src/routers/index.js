import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '../components/layouts/Index.vue'

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
            {
                path: 'system',
                name: '系统设置',
                component: _import('system/Index'),
                children: [
                    { path: 'users', name: '用户管理', component: _import('system/children/User') },
                    { path: 'roles', name: '角色管理', component: _import('system/children/Role') },
                    {
                        path: 'permissions', name: '权限管理', component: _import('system/children/Permission'),
                        redirect: '/system/permissions/index',
                        children: [
                            { path: 'index', name: '权限列表', component: _import('system/children/PermissionIndex') },
                            { path: 'create', name: '创建权限', component: _import('system/children/PermissionCreate') },
                            { path: 'edit/:permission_id', name: '编辑权限', component: _import('system/children/PermissionEdit') },
                        ]
                    },
                ]
            },
            { path: 'follow', name: '粉丝管理', component: _import('wechat/Follow') },
            { path: 'nav', name: '菜单管理', component: _import('wechat/Nav') },
            { path: 'setting', name: '基础配置', component: _import('shop/Setting') },
            { path: 'product', name: '商品管理', component: _import('shop/Product') },
        ]
    },
    { path: '*', name: '404', component: _import('404') },
];

export default new VueRouter({
    mode: 'hash',
    scrollBehavior: () => ({ y: 0 }),
    routes: RouterMap
});