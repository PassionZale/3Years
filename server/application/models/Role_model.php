<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_roles()
    {
        $query = $this->db->get('auth_role');
        return $query->result_array();
    }

    public function create($data)
    {
        $role = array(
            'name' => $data['name'],
            'alias' => $data['alias'],
            'created_at' => current_date(),
            'updated_at' => current_date()
        );
        $this->db->insert('auth_role', $role);

        $role_id = $this->db->insert_id();

        $permissions = isset($data['permissions']) ? $data['permissions'] : FALSE;

        if ($permissions) {
            $role_permission = array();
            foreach ($permissions as $permission) {
                $role_permission[] = array(
                    'role_id' => $role_id,
                    'permission_id' => $permission,
                    'created_at' => current_date(),
                    'updated_at' => current_date()
                );
            }
            $this->db->insert_batch('auth_role_permission', $role_permission);
        }
        return TRUE;
    }

    public function delete($id)
    {
        $query = $this->db->get_where('auth_role', ['id' => $id]);
        $result = $query->row_array();
        if ($result) {
            $this->db->where('id', $id)->delete('auth_role');
            $this->db->where('role_id', $id)->delete('auth_role_permission');
            $this->db->where('role_id', $id)->delete('auth_user_role');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function show($id)
    {
        $query = $this->db->select('name, alias')->where('id', $id)->get('auth_role');
        $result = $query->row_array();
        $query = $this->db->select('permission_id')->where('role_id', $id)->get('auth_role_permission');
        $permissions = $query->result_array();
        foreach ($permissions as $permission) {
            $result['permissions'][] = $permission['permission_id'];
        }
        return $result;
    }

    public function update($id, $data)
    {
        $role = array(
            'name' => $data['name'],
            'alias' => $data['alias'],
            'updated_at' => current_date()
        );
        $this->db->where('id', $id)->update('auth_role', $role);
        $this->db->delete('auth_role_permission', ['role_id' => $id]);

        $permissions = isset($data['permissions']) ? $data['permissions'] : FALSE;

        if ($permissions) {
            $role_permission = array();
            foreach ($permissions as $permission) {
                $role_permission[] = array(
                    'role_id' => $id,
                    'permission_id' => $permission,
                    'created_at' => current_date(),
                    'updated_at' => current_date()
                );
            }
            $this->db->insert_batch('auth_role_permission', $role_permission);
        }
        return TRUE;
    }

}