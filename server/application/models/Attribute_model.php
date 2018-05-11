<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function show($id)
    {

    }

    public function create($data)
    {
        $category_id = $data['category_id'];

        $this->db->trans_begin();

        foreach ($data['attributes'] as $attr) {
            // 操作商品规格表
            $attribute = array(
                'category_id' => $category_id,
                'name' => $attr['name'],
                'created_at' => current_date(),
                'updated_at' => current_date(),
            );
            $result = $this->db->insert('product_attributes', $attribute);
            if ($result === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
            // 获取规格插入ID
            $attribute_id = $this->db->insert_id();
            $items = array();
            foreach ($attr['items'] as $item) {
                $items[] = array(
                    'attribute_id' => $attribute_id,
                    'name' => $item['name'],
                    'created_at' => current_date(),
                    'updated_at' => current_date(),
                );
            }
            // 批量插入规格选项
            $this->db->insert_batch('product_items', $items);
            // 若没有全部插入则回滚事物
            if ($this->db->affected_rows() !== count($items)) {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {

    }

}