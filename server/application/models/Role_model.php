<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_roles() {
        $query = $this->db->get('auth_role');
        return $query->result_array();
    }

}