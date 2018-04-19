<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 判断 superuser 是否存在
     *
     * @return bool
     */
    public function superuser_exist()
    {
        $filter = array(
            'is_active' => 1,
            'is_superuser' => 1,
        );
        $query = $this->db->get_where('auth_user', $filter);
        $superuser_exist = $query->row_array();
        if ($superuser_exist) {
            $this->superuser_lock();
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 判断 superuser.lock 文件是否存在
     *
     * ./application/superuser.lock
     */
    public function superuser_lock()
    {
        if (!file_exists(APPPATH . 'superuser.lock')) {
            $this->load->helper('file');
            $data = 'Don\'t delete this file.';
            if (!write_file(APPPATH . 'superuser.lock', $data)) {
                exit('Unable to write the .superuserlock file');
            }
        }
    }

    /**
     * 登录用户
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function user_login($username, $password)
    {
        $this->db->select('id, username, email, password');
        $this->db->where('username', $username);
        $query = $this->db->get('auth_user');
        $user = $query->row_array();
        if ($user) {
            $verify = password_verify($password, $user['password']);
            if ($verify) {
                $data = array('last_login' => current_date());
                $this->db->where('id', $user['id']);
                $this->db->update('auth_user', $data);
                return $user;
            }
        }
        return FALSE;
    }

    /**
     * 创建用户
     *
     * @param $data
     * @param bool $is_superuser 为 TRUE 时，创建 superuser
     * @return mixed
     */
    public function user_create($data, $is_superuser = FALSE)
    {
        $options = [
            'cost' => 8,
        ];
        $pwd_hash = password_hash($data['password'], PASSWORD_DEFAULT, $options);
        $data['password'] = $pwd_hash;
        if (array_key_exists('password_confirm', $data)) {
            unset($data['password_confirm']);
        }
        if ($is_superuser) {
            $data['is_superuser'] = 1;
        }
        $data['created_at'] = current_date();
        return $this->db->insert('auth_user', $data);
    }

}