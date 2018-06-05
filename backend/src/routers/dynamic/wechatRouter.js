const _import = file => () => import('../../views/' + file + '.vue');

const wechatRouter = {
    path: 'wechat',
    name: '公众号设置',
    component: _import('wechat/Index'),
    children: [
        {
            path: 'follow', name: '粉丝列表', component: _import('wechat/children/Follow'),
        }
    ]
};

export default wechatRouter;