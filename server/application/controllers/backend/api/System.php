<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class System extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'User');
        $this->load->model('Role_model', 'Role');
    }

    // 用户列表
    public function users_get()
    {
        $response = array();
        $users = $this->User->get_users();
        foreach ($users as $user) {
            $role = $this->User->get_user_role($user['id']);
            $permissions = $this->User->get_user_permissions($role['id']);
            $response[] = array(
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'last_login' => $user['last_login'],
                'is_superuser' => $user['is_superuser'],
                'role' => $role['alias'],
                'permissions' => $permissions
            );
        }
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => $response
        ), REST_Controller::HTTP_OK);
    }

    // 角色列表
    public function roles_get()
    {
        $roles = $this->Role->get_roles();
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => $roles
        ), REST_Controller::HTTP_OK);
    }

    // 权限列表
    public function permissions_get()
    {
        $permissions = $this->Permission->get_permissions();
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => $permissions
        ), REST_Controller::HTTP_OK);
    }

    public function user_role_permission_get($user_id)
    {
        $role = $this->User->get_user_role($user_id);
        $permissions = $this->User->get_user_permissions($role['id']);
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => array(
                'role' => $role,
                'permissions' => $permissions
            )
        ), REST_Controller::HTTP_OK);
    }

}