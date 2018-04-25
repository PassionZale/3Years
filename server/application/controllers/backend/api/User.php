<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation', 'form');
        $this->load->model('User_model', 'UserModel');
    }

    public function index_get()
    {
        $user_id = Authorization::getUserIdFromToken();
        $user = $this->UserModel->get_user_by_id($user_id);
        if ($user) {
            $this->set_response(array(
                'ret_code' => 0,
                'ret_msg' => $user
            ), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(
                'ret_code' => -1,
                'ret_msg' => '用户不存在'
            ), REST_Controller::HTTP_OK);
        }
    }

    public function userinfo_put()
    {
        $data = $this->put();
        $this->form_validation->set_data($data);
        if ($this->form_validation->run('userinfo_update') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $user_id = Authorization::getUserIdFromToken();
            $user = $this->UserModel->update_userinfo($user_id, $data);
            if ($user) {
                $this->set_response(array(
                    'ret_code' => 0,
                    'ret_msg' => $user
                ), REST_Controller::HTTP_OK);
            } else {
                $this->set_response(array(
                    'ret_code' => -1,
                    'ret_msg' => '用户不存在'
                ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function userpwd_put()
    {
        $data = $this->put();
        $this->form_validation->set_data($data);
        if ($this->form_validation->run('userpwd_update') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $user_id = Authorization::getUserIdFromToken();
            $result = $this->UserModel->update_userpwd($user_id, $data);
            if ($result) {
                $this->set_response(array(
                    'ret_code' => 0,
                    'ret_msg' => '密码修改成功'
                ), REST_Controller::HTTP_OK);
            } else {
                $this->set_response(array(
                    'ret_code' => -1,
                    'ret_msg' => '旧密码不正确'
                ), REST_Controller::HTTP_OK);
            }
        }
    }

}