<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sku_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('product_skus', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('product_skus', ['id' => $id]);
    }

    public function create($data){
        foreach ($data as $sku) {
            $query = array(
                'product_id' => $sku['product_id'],
                'price' => $sku['sku_price'],
                'stock' => $sku['sku_stock'],
            );
            $this->db->insert('product_skus', $query);
            $sku_id = $this->db->insert_id();
            // product_skus_items
            $skus_items = [];
            foreach ($sku['values'] as $value) {
                $skus_items[] = array(
                    'sku_id' => $sku_id,
                    'item_id' => $value['item_id'],
                    'attribute_id' => $value['attribute_id']
                );
            }
            $this->db->insert_batch('product_skus_items', $skus_items);
        }
        return TRUE;
    }

}