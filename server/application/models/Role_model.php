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
        $permissions = $data['permissions'];

        $role_permission = array();
        foreach ($permissions as $permission) {
            $role_permission[] = array(
                'role_id' => $role_id,
                'permission_id' => $permission,
                'created_at' => current_date(),
                'updated_at' => current_date()
            );
        }
        return $this->db->insert_batch('auth_role_permission', $role_permission);
    }

}