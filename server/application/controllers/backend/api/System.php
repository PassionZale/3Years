<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class System extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation', 'form');
        $this->load->model('User_model', 'User');
        $this->load->model('Role_model', 'Role');
        $this->load->model('Permission_model', 'Permission');
    }

//    public function user_role_permission_get($user_id)
//    {
//        $role = $this->User->get_user_role($user_id);
//        $permissions = $this->User->get_user_permissions($role['id']);
//        $this->set_response(array(
//            'ret_code' => 0,
//            'ret_msg' => array(
//                'role' => $role,
//                'permissions' => $permissions
//            )
//        ), REST_Controller::HTTP_OK);
//    }

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

    /*------ 权限 CRUD ------*/
    public function permission_post()
    {
        if ($this->form_validation->run('permission') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $data = $this->input->post();
            $result = $this->Permission->create($data);
            $this->set_response(array(
                'ret_code' => 0,
                'ret_msg' => $result
            ), REST_Controller::HTTP_OK);
        }
    }

    public function permission_delete($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Permission->delete($id);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function permission_get($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Permission->show($id);
            $result ? echoMsg(0, $result) : echoFail();
        }
    }

    public function permission_put($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->put();
            $this->form_validation->set_data($data);
            if ($this->form_validation->run('permission') === FALSE) {
                $errors = $this->form_validation->error_array();
                echoFail(current($errors));
            } else {
                $result = $this->Permission->update($id, $data);
                $result ? echoSuccess() : echoFail();
            }
        }
    }

    /*------ 角色 CRUD ------*/
    public function role_post()
    {
        if ($this->form_validation->run('role') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $data = $this->input->post();
            $result = $this->Role->create($data);
            $this->set_response(array(
                'ret_code' => 0,
                'ret_msg' => $result
            ), REST_Controller::HTTP_OK);
        }
    }

    public function role_delete($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Role->delete($id);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function role_get($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->Role->show($id);
            $result ? echoMsg(0, $result) : echoFail();
        }
    }

    public function role_put($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->put();
            $this->form_validation->set_data($data);
            if ($this->form_validation->run('role') === FALSE) {
                $errors = $this->form_validation->error_array();
                echoFail(current($errors));
            } else {
                $result = $this->Role->update($id, $data);
                $result ? echoSuccess() : echoFail();
            }
        }
    }

    /*------ 用户 CRUD ------*/
    public function user_post()
    {
        if ($this->form_validation->run('auth_register') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $data = $this->input->post();
            $result = $this->User->create($data);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function user_delete($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $result = $this->User->delete($id);
            $result ? echoMsg(0, $result) : echoFail();
        }
    }

    public function user_show($id)
    {

    }

    public function user_put($id)
    {

    }

}