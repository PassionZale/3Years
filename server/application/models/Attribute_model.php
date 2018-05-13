<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $query = $this->db->select('
            c.name as category,
            a.name, 
            a.id, 
            a.created_at, 
            a.updated_at
        ')->from('product_attributes as a')
            ->join('product_categories as c', 'c.id = a.category_id')
            ->get();
        $attributes = $query->result_array();
        $response = array();
        foreach ($attributes as $attribute) {
            $query = $this->db->where('attribute_id', $attribute['id'])
                ->from('product_items')
                ->get();
            $attribute['items'] = $query->result_array();
            $response[] = $attribute;
        }
        return $response;
    }

    public function show($id)
    {
        $query = $this->db->select('category_id, name')->where('id', $id)->from('product_attributes')->get();
        $attribute = $query->row_array();
        $query = $this->db->select('attribute_id, name')->where('attribute_id', $id)->from('product_items')->get();
        $items = $query->result_array();
        $attribute['items'] = $items;
        return $attribute;
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
        $attribute = array(
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'updated_at' => current_date()
        );
        $this->db->trans_begin();

        $this->db->where('id', $id)->update('product_attributes', $attribute);
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->where('attribute_id', $id)->delete('product_items');
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $items = $data['items'];
        $this->db->insert_batch('product_items', $items);
        if ($this->db->affected_rows() !== count($items)) {
            $this->db->trans_rollback();
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }

    public function delete($id)
    {

    }

}