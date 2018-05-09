const _import = file => () => import('../../views/' + file + '.vue');

const systemRouter = {
    path: 'system',
    name: '系统设置',
    component: _import('system/Index'),
    children: [
        {
            path: 'users', name: '用户管理', component: _import('system/children/User'),
            redirect: '/system/users/index',
            children: [
                { path: 'index', name: '用户列表', component: _import('system/children/UserIndex') },
                { path: 'create', name: '创建用户', component: _import('system/children/UserCreate') },
                { path: 'edit/:user_id', name: '编辑用户', component: _import('system/children/UserEdit') },
            ]
        },
        {
            path: 'roles', name: '角色管理', component: _import('system/children/Role'),
            redirect: '/system/roles/index',
            children: [
                { path: 'index', name: '角色列表', component: _import('system/children/RoleIndex') },
                { path: 'create', name: '创建角色', component: _import('system/children/RoleCreate') },
                { path: 'edit/:role_id', name: '编辑角色', component: _import('system/children/RoleEdit') },
            ]
        },
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
};

export default systemRouter;