<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function all_child_categories()
    {
        $query = $this->db->where('p_id !=', 0)->from('product_categories')->get();
        return $query->result_array();
    }

    public function child_categories($id)
    {
        $query = $this->db->where('p_id', $id)->from('product_categories')->get();
        return $query->result_array();
    }

    public function parent_categories()
    {
        $query = $this->db->where('p_id', 0)->from('product_categories')->get();
        return $query->result_array();
    }

    public function show($id)
    {
        $query = $this->db->where('id', $id)->from('product_categories')->get();
        return $query->row_array();
    }

    public function create($data)
    {
        $data['created_at'] = current_date();
        $data['updated_at'] = current_date();
        $this->db->insert('product_categories', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = current_date();
        $result = $this->db->where('id', $id)->update('product_categories', $data);
        return $result;
    }

    public function delete($id)
    {
        $query = $this->db->where('id', $id)->from('product_categories')->get();
        $category = $query->row_array();
        if ($category) {
            $this->db->where('id', $id)->delete('product_categories');
            if ($category['p_id'] == 0) {
                $this->db->where('p_id', $category['id'])->delete('product_categories');
            }
            return TRUE;
        }
        return FALSE;
    }

}