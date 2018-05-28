<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Freight_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function show()
    {
        $query = $this->db->select('cost_freight,free_freight')->from('shop_freight')->get();
        $result = $query->row_array();
        if (!$result) {
            $freight = array(
                'cost_freight' => 0.0,
                'free_freight' => 0.0
            );
        } else {
            $freight = array(
                'cost_freight' => (float)$result['cost_freight'],
                'free_freight' => (float)$result['free_freight']
            );
        }
        return $freight;
    }

    public function update($data)
    {
        $this->db->truncate('shop_freight');
        return $this->db->insert('shop_freight', $data);
    }
}