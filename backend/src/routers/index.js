import Vue from 'vue'
import VueRouter from 'vue-router'
import Layout from '../components/layouts/Index.vue'

Vue.use(VueRouter);

const _import = file => () => import('../views/' + file + '.vue');

export const basicRouterMap = [
    { path: '/login', name: '登录', component: _import('auth/Login') },
    { path: '/superuser', name: '超级用户', component: _import('auth/Superuser') },
    { path: '/404', name: '404', component: _import('404') },
    {
        path: '/',
        component: Layout,
        redirect: '/console',
        children: [
            { path: 'console', name: '首页', component: _import('console/Index') },
            { path: 'user', name: '个人中心', component: _import('user/Index') },
        ]
    },
];

export default new VueRouter({
    mode: 'hash',
    scrollBehavior: () => ({ y: 0 }),
    routes: basicRouterMap
});

export const dynamicRouterMap = [
    {
        path: '/system',
        name: '系统设置',
        component: Layout,
        children: [
            {
                path: 'users', name: '用户管理', icon:'person-stalker', component: _import('system/children/User'),
                redirect: '/system/users/index',
                children: [
                    { path: 'index', name: '用户列表', component: _import('system/children/UserIndex') },
                    { path: 'create', name: '创建用户', component: _import('system/children/UserCreate') },
                    { path: 'edit/:user_id', name: '编辑用户', component: _import('system/children/UserEdit') },
                ]
            },
            {
                path: 'roles', name: '角色管理', icon:'ionic', component: _import('system/children/Role'),
                redirect: '/system/roles/index',
                children: [
                    { path: 'index', name: '角色列表', component: _import('system/children/RoleIndex') },
                    { path: 'create', name: '创建角色', component: _import('system/children/RoleCreate') },
                    { path: 'edit/:role_id', name: '编辑角色', component: _import('system/children/RoleEdit') },
                ]
            },
            {
                path: 'permissions', name: '权限管理', icon:'locked', component: _import('system/children/Permission'),
                redirect: '/system/permissions/index',
                children: [
                    { path: 'index', name: '权限列表', component: _import('system/children/PermissionIndex') },
                    { path: 'create', name: '创建权限', component: _import('system/children/PermissionCreate') },
                    { path: 'edit/:permission_id', name: '编辑权限', component: _import('system/children/PermissionEdit') },
                ]
            },
        ]
    },

    {
        path: '/product',
        name: '商品设置',
        component: Layout,
        children: [
            {
                path: 'commodity', name: '商品管理', icon:'bag', component: _import('product/children/Product'),
                redirect: '/product/commodity/index',
                children: [
                    { path: 'index', name: '商品列表', component: _import('product/children/ProductIndex') },
                    { path: 'create', name: '创建商品', component: _import('product/children/ProductCreate') },
                    { path: 'edit/:id', name: '编辑商品', component: _import('product/children/ProductEdit') },
                ]
            },
            {
                path: 'category', name: '分类管理', icon:'ios-pricetag', component: _import('product/children/Category'),
                redirect: '/product/category/index',
                children: [
                    { path: 'index', name: '分类列表', component: _import('product/children/CategoryIndex') },
                    { path: 'create', name: '创建分类', component: _import('product/children/CategoryCreate') },
                    { path: 'edit/:id', name: '编辑分类', component: _import('product/children/CategoryEdit') },
                ]
            },
            {
                path: 'attribute', name: '规格管理', icon:'ios-pricetag-outline', component: _import('product/children/Attribute'),
                redirect: '/product/attribute/index',
                children: [
                    { path: 'index', name: '规格列表', component: _import('product/children/AttributeIndex') },
                    { path: 'create', name: '创建规格', component: _import('product/children/AttributeCreate') },
                    { path: 'edit/:id', name: '编辑规格', component: _import('product/children/AttributeEdit') },
                ]
            },
        ]
    },

    {
        path: '/shop',
        name: '商城设置',
        component: Layout,
        children: [
            {
                path: 'freight', name: '运费管理', icon:'social-yen', component: _import('shop/children/Freight'),
            },
            {
                path: 'banner', name: '轮播图管理', icon:'images', component: _import('shop/children/Banner'),
                redirect: '/shop/banner/index',
                children: [
                    { path: 'index', name: '轮播图列表', component: _import('shop/children/BannerIndex') },
                    { path: 'create', name: '创建轮播图', component: _import('shop/children/BannerCreate') },
                    { path: 'edit/:id', name: '编辑轮播图', component: _import('shop/children/BannerEdit') },
                ]
            },
            {
                path: 'recommend', name: '推荐管理', icon:'thumbsup', component: _import('shop/children/Recommend'),
            },
        ]
    },

    {
        path: '/wechat',
        name: '公众号设置',
        component: Layout,
        children: [
            {
                path: 'follow', name: '粉丝列表', icon:'android-favorite', component: _import('wechat/children/Follow'),
            }
        ]
    },

    { path: '*', redirect: '/404' }
];

