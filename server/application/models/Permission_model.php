<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function is_superuser($user_id)
    {
        $filter = array(
            'id' => $user_id
        );
        $query = $this->db->get_where('auth_user', $filter);
        $user = $query->row_array();
        if ($user && $user['is_superuser']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function resource_exist($resource)
    {
        $filter = array(
            'resource' => $resource
        );
        $query = $this->db->get_where('auth_permission', $filter);
        $permission = $query->row_array();
        return $permission ? TRUE : FALSE;
    }

    public function has_permission($user_id, $resource)
    {
        $role = $this->get_role_by_user($user_id);
        return $this->get_permission_by_role($role['id'], $resource);
    }

    private function get_role_by_user($user_id)
    {
//        "SELECT `auth_role`.`id`, `auth_role`.`name` FROM `auth_role`
//           INNER JOIN `auth_user_role` ON `auth_user_role`.`role_id` = `auth_role`.`id`
//           WHERE   (
//             `auth_user_role`.`user_id` = '7'
//           )"
        $this->db->select('auth_role.id, auth_role.name')->from('auth_role')
            ->join('auth_user_role', 'auth_user_role.role_id = auth_role.id', 'inner')
            ->group_start()
            ->where('auth_user_role.user_id', $user_id)
            ->group_end();
        $query = $this->db->get();
        return $query->row_array();
    }

    private function get_permission_by_role($role_id, $resource)
    {
//        "SELECT `auth_permission`.`id`, `auth_permission`.`name`, `auth_permission`.`resource`
//        FROM `auth_permission`
//        INNER JOIN `auth_role_permission` ON `auth_role_permission`.`permission_id` = `auth_permission`.`id`
//        WHERE   (
//        `auth_permission`.`resource` = 'user'
//         )
//        AND   (
//        `auth_role_permission`.`role_id` = '1'
//         )"
        $this->db->select('auth_permission.id, auth_permission.name, auth_permission.resource')
            ->group_start()
            ->where('auth_permission.resource', $resource)
            ->group_end()
            ->from('auth_permission')
            ->join('auth_role_permission', 'auth_role_permission.permission_id = auth_permission.id', 'inner')
            ->group_start()
            ->where('auth_role_permission.role_id', $role_id)
            ->group_end();
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_permissions()
    {
        $query = $this->db->get('auth_permission');
        return $query->result_array();
    }

    public function show($id)
    {
        $query = $this->db->select('id, name, resource')->where('id', $id)->get('auth_permission');
        $result = $query->row_array();
        return $result;
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('auth_permission', $data);
    }

    public function create($data)
    {
        $data['created_at'] = current_date();
        $data['updated_at'] = current_date();
        return $this->db->insert('auth_permission', $data);
    }

    public function delete($id)
    {
        $query = $this->db->get_where('auth_permission', ['id' => $id]);
        $result = $query->row_array();
        if ($result) {
            $this->db->where('id', $id)->delete('auth_permission');
            $this->db->where('permission_id', $id)->delete('auth_role_permission');
            return TRUE;
        } else {
            return FALSE;
        }
    }

}