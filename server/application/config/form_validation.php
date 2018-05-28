<?php
$sort = array(
    'field' => 'sort',
    'label' => '排序',
    'rules' => 'trim|required|is_natural',
    'errors' => array(
        'required' => '%s 不能为空',
        'is_natural' => '%s 为大于等于0的整数',
    )
);

$config = array(
    'auth_login' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
    ),
    'auth_register' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|is_unique[auth_user.username]|regex_match[/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/]',
            'errors' => array(
                'required' => '%s 不能为空',
                'is_unique' => '%s 已被占用',
                'regex_match' => '%s 以字母开头，长度在5~16之间，只能包含字母、数字和下划线',
            )
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z]\w{5,17}$/]',
            'errors' => array(
                'required' => '%s 不能为空',
                'regex_match' => '%s 以字母开头，长度在6~18之间，只能包含字母、数字和下划线',
            )
        ),
        array(
            'field' => 'password_confirm',
            'label' => '确认密码',
            'rules' => 'trim|required|matches[password]',
            'errors' => array(
                'required' => '%s 不能为空',
                'matches' => '密码两次输入不相同'
            )
        ),
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'required|is_unique[auth_user.email]|valid_email',
            'errors' => array(
                'required' => '%s 不能为空',
                'is_unique' => '%s 已被占用',
                'valid_email' => '邮箱输入不合法'
            )
        )
    ),
    'userinfo_update' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|is_unique[auth_user.username]|regex_match[/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/]',
            'errors' => array(
                'required' => '%s 不能为空',
                'is_unique' => '%s 已被占用',
                'regex_match' => '%s 以字母开头，长度在5~16之间，只能包含字母、数字和下划线',
            )
        ),
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'required|is_unique[auth_user.email]|valid_email',
            'errors' => array(
                'required' => '%s 不能为空',
                'is_unique' => '%s 已被占用',
                'valid_email' => '邮箱输入不合法'
            )
        ),
    ),
    'userpwd_update' => array(
        array(
            'field' => 'old_password',
            'label' => '旧密码',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z]\w{5,17}$/]',
            'errors' => array(
                'required' => '%s 不能为空',
                'regex_match' => '%s 以字母开头，长度在6~18之间，只能包含字母、数字和下划线',
            )
        ),
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z]\w{5,17}$/]',
            'errors' => array(
                'required' => '%s 不能为空',
                'regex_match' => '%s 以字母开头，长度在6~18之间，只能包含字母、数字和下划线',
            )
        ),
        array(
            'field' => 'password_confirm',
            'label' => '确认密码',
            'rules' => 'trim|required|matches[password]',
            'errors' => array(
                'required' => '%s 不能为空',
                'matches' => '新密码两次输入不相同'
            )
        )
    ),
    'permission' => array(
        array(
            'field' => 'name',
            'label' => '权限名称',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
        array(
            'field' => 'resource',
            'label' => '权限资源',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
    ),
    'role' => array(
        array(
            'field' => 'name',
            'label' => '角色名称',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
        array(
            'field' => 'alias',
            'label' => '角色别名',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
    ),
    'category' => array(
        array(
            'field' => 'name',
            'label' => '分类名称',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
        $sort
    ),
    'banner' => array(
        $sort,
        array(
            'field' => 'imgurl',
            'label' => '轮播图',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
        array(
            'field' => 'redirect',
            'label' => '跳转链接',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => '%s 不能为空',
            )
        ),
    ),
);