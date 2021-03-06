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
        $this->db->select('id, username, email, password, is_active');
        $this->db->where('username', $username);
        $query = $this->db->get('auth_user');
        $user = $query->row_array();
        if ($user) {
            if ($user['is_active'] == 1) {
                $verify = password_verify($password, $user['password']);
                if ($verify) {
                    $data = array('last_login' => current_date());
                    $this->db->where('id', $user['id']);
                    $this->db->update('auth_user', $data);
                    return $user;
                } else {
                    return 'login error';
                }
            } else {
                return 'account disabled';
            }
        }
        return 'not found';
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

    public function is_active($id)
    {
        $query = $this->db->select('is_active')->where('id', $id)->from('auth_user')->get();
        $result = $query->row_array();
        return $result['is_active'] == 1 ? TRUE : FALSE;
    }

    public function is_visitor($id){
        $filter = array(
            'id' => $id,
            'username' => 'visitor'
        );
        $query = $this->db->where($filter)->get('auth_user');
        return $query->row_array();
    }

    public function get_user_by_id($id)
    {
        $query = $this->db->where('id', $id)->get('auth_user');
        $user = $query->row_array();
        if($user['is_superuser']){
            $role = 'superuser';
            $permissions = 'all';
        }else{
            $query = $this->db->where('user_id', $id)->get('auth_user_role');
            $user_role = $query->row_array();
            $query = $this->db->select('id, name, alias')->where('id', $user_role['role_id'])->get('auth_role');
            $role = $query->row_array();
            $query = $this->db->select('p.name, p.resource')
                ->where('r.role_id', $user_role['role_id'])
                ->join('auth_permission as p', 'p.id = r.permission_id')
                ->from('auth_role_permission as r')
                ->get();
            $permissions = $query->result_array();
        }

        $response = array(
            'id' => $id,
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $role,
            'permissions' => $permissions
        );

        return $response;
    }

    public function update_userinfo($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('auth_user');
        $user = $query->row_array();
        if ($user) {
            $data['updated_at'] = current_date();
            $this->db->where('id', $id)->update('auth_user', $data);
            return array(
                'id' => $id,
                'username' => $data['username'],
                'email' => $data['email']
            );
        }
        return FALSE;
    }

    public function update_userpwd($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('auth_user');
        $user = $query->row_array();
        if ($user) {
            $verify = password_verify($data['old_password'], $user['password']);
            if ($verify) {
                $options = [
                    'cost' => 8,
                ];
                $pwd_hash = password_hash($data['password'], PASSWORD_DEFAULT, $options);
                $this->db->where('id', $id)->update('auth_user', array(
                    'password' => $pwd_hash,
                    'updated_at' => current_date()
                ));
                return TRUE;
            }
        }
        return FALSE;
    }

    public function get_users()
    {
        $query = $this->db->select('id, username, email, last_login, is_superuser, is_active')
            ->from('auth_user')
            ->order_by('id', 'ASC')
            ->get();
        return $query->result_array();
    }

    public function get_user_role($user_id)
    {
        $this->db->select('auth_role.id, auth_role.name, auth_role.alias')->from('auth_role')
            ->join('auth_user_role', 'auth_user_role.role_id = auth_role.id', 'inner')
            ->group_start()
            ->where('auth_user_role.user_id', $user_id)
            ->group_end();
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_user_permissions($role_id)
    {
        $this->db->select('auth_permission.id, auth_permission.name, auth_permission.resource')
            ->from('auth_permission')
            ->join('auth_role_permission', 'auth_role_permission.permission_id = auth_permission.id', 'inner')
            ->group_start()
            ->where('auth_role_permission.role_id', $role_id)
            ->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create($data)
    {
        $options = [
            'cost' => 8,
        ];
        $pwd_hash = password_hash($data['password'], PASSWORD_DEFAULT, $options);
        $user = array(
            'username' => $data['username'],
            'password' => $pwd_hash,
            'email' => $data['email'],
            'created_at' => current_date()
        );
        $this->db->insert('auth_user', $user);
        $user_id = $this->db->insert_id();

        $role_id = isset($data['role']) ? $data['role'] : FALSE;

        if ($role_id) {
            $user_role = array(
                'user_id' => $user_id,
                'role_id' => $role_id,
                'created_at' => current_date(),
                'updated_at' => current_date()
            );
            $this->db->insert('auth_user_role', $user_role);
        }

        return TRUE;
    }

    public function delete($id)
    {
        $query = $this->db->get_where('auth_user', ['id' => $id]);
        $result = $query->row_array();
        if ($result) {
            $this->db->where('id', $id)->delete('auth_user');
            $this->db->where('user_id', $id)->delete('auth_user_role');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function show($id)
    {
        $query = $this->db->select('email, username, is_active')->where('id', $id)->get('auth_user');
        $result = $query->row_array();
        $query = $this->db->select('role_id')->where('user_id', $id)->get('auth_user_role');
        $role = $query->row_array();
        $result['role'] = $role['role_id'];
        return $result;
    }

    public function update($id, $data)
    {
        $user = array(
            'is_active' => $data['is_active'],
            'updated_at' => current_date()
        );
        $this->db->where('id', $id)->update('auth_user', $user);
        if (isset($data['role'])) {
            $query = $this->db->where('user_id', $id)->from('auth_user_role')->get();
            $user_role = $query->row_array();
            if (!$user_role) {
                $role = array(
                    'user_id' => $id,
                    'role_id' => $data['role'],
                    'created_at' => current_date(),
                    'updated_at' => current_date()
                );
                $this->db->insert('auth_user_role', $role);
            } else {
                if ($user_role['role_id'] !== $data['role']) {
                    $role = array(
                        'role_id' => $data['role'],
                        'updated_at' => current_date()
                    );
                    $this->db->where('user_id', $id)->update('auth_user_role', $role);
                }
            }
        }
        return TRUE;
    }

}