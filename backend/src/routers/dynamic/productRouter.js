const _import = file => () => import('../../views/' + file + '.vue');

const productRouter = {
    path: 'product',
    name: '商品设置',
    component: _import('product/Index'),
    children: [
        {
            path: 'category', name: '分类管理', component: _import('product/children/Category'),
            redirect: '/product/category/index',
            children: [
                { path: 'index', name: '分类列表', component: _import('product/children/CategoryIndex') },
                { path: 'create', name: '创建分类', component: _import('product/children/CategoryCreate') },
                { path: 'edit/:id', name: '编辑分类', component: _import('product/children/CategoryEdit') },
            ]
        },
    ]
};

export default productRouter;