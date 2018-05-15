const _import = file => () => import('../../views/' + file + '.vue');

const productRouter = {
    path: 'product',
    name: '商品设置',
    redirect: '/product/',
    component: _import('product/Index'),
    children: [
        {
            path: 'commodity', name: '商品管理', component: _import('product/children/Product'),
            redirect: '/product/commodity/index',
            children: [
                { path: 'index', name: '商品列表', component: _import('product/children/ProductIndex') },
                { path: 'create', name: '创建商品', component: _import('product/children/ProductCreate') },
                { path: 'edit/:id', name: '编辑商品', component: _import('product/children/ProductEdit') },
            ]
        },
        {
            path: 'category', name: '分类管理', component: _import('product/children/Category'),
            redirect: '/product/category/index',
            children: [
                { path: 'index', name: '分类列表', component: _import('product/children/CategoryIndex') },
                { path: 'create', name: '创建分类', component: _import('product/children/CategoryCreate') },
                { path: 'edit/:id', name: '编辑分类', component: _import('product/children/CategoryEdit') },
            ]
        },
        {
            path: 'attribute', name: '规格管理', component: _import('product/children/Attribute'),
            redirect: '/product/attribute/index',
            children: [
                { path: 'index', name: '规格列表', component: _import('product/children/AttributeIndex') },
                { path: 'create', name: '创建规格', component: _import('product/children/AttributeCreate') },
                { path: 'edit/:id', name: '编辑规格', component: _import('product/children/AttributeEdit') },
            ]
        },
    ]
};

export default productRouter;