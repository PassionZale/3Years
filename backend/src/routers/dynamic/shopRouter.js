const _import = file => () => import('../../views/' + file + '.vue');

const shopRouter = {
    path: 'shop',
    name: '商城设置',
    component: _import('shop/Index'),
    children: [
        {
            path: 'freight', name: '运费管理', component: _import('shop/children/Freight'),
        },
        {
            path: 'banner', name: '轮播图管理', component: _import('shop/children/Banner'),
            redirect: '/shop/banner/index',
            children: [
                { path: 'index', name: '轮播图列表', component: _import('shop/children/BannerIndex') },
                { path: 'create', name: '创建轮播图', component: _import('shop/children/BannerCreate') },
                { path: 'edit/:id', name: '编辑轮播图', component: _import('shop/children/BannerEdit') },
            ]
        },
        {
            path: 'topic', name: '专题管理', component: _import('shop/children/Topic'),
            redirect: '/shop/topic/index',
            children: [
                { path: 'index', name: '专题列表', component: _import('shop/children/TopicIndex') },
                { path: 'create', name: '创建专题', component: _import('shop/children/TopicCreate') },
                { path: 'edit/:id', name: '编辑专题', component: _import('shop/children/TopicEdit') },
            ]
        },
        {
            path: 'recommend', name: '推荐管理', component: _import('shop/children/Recommend'),
        },
    ]
};

export default shopRouter;