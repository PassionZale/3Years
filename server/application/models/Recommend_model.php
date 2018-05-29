<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recommend_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function show()
    {
        $this->db->select('r.id, r.product_id, p.name')->from('shop_recommend as r')
            ->join('product_products as p', 'p.id = r.product_id')
            ->order_by('r.id desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function create($data)
    {
        $query = $this->db->get_where('shop_recommend', ['product_id' => $data['product_id']]);
        if ($query->row_array()) {
            return FALSE;
        } else {
            $data['created_at'] = $data['updated_at'] = current_date();
            $this->db->insert('shop_recommend', $data);
            $id = $this->db->insert_id();
            if ($id) {
                $query = $this->db->get_where('product_products', ['id' => $data['product_id']]);
                $product = $query->row_array();
                return array(
                    'id' => $id,
                    'product_id' => $data['product_id'],
                    'name' => $product['name'],
                );
            } else {
                return FALSE;
            }
        }
    }

    public function delete($id)
    {
        return $this->db->delete('shop_recommend', ['id' => $id]);
    }
}