<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {

        $this->db->trans_start();

        // product_products
        $product = array(
            'category_id' => $data['category'][1],
            'name' => $data['name'],
            'thumb_img' => $data['thumb_img']['url'],
            // TODO 价格正则校验
            'original_price' => $data['original_price'],
            'current_price' => $data['current_price'],
            'sold' => $data['sold'],
            'stock' => $data['stock'],
            'status' => $data['status'],
            'sort' => $data['sort'],
            'base_info' => $data['base_info'],
            'detail_info' => $data['detail_info'],
            'created_at' => current_date(),
            'updated_at' => current_date(),
        );
        $this->db->insert('product_products', $product);
        $product_id = $this->db->insert_id();

        // product_products_banners
        $banners = [];
        foreach ($data['banners'] as $banner) {
            $banners[] = array(
                'product_id' => $product_id,
                'imgurl' => $banner['url']
            );
        }
        $this->db->insert_batch('product_products_banners', $banners);

        // product_skus
        foreach ($data['skus'] as $sku) {
            $query = array(
                'product_id' => $product_id,
                'price' => $sku['sku_price'],
                'stock' => $sku['sku_stock'],
            );
            $this->db->insert('product_skus', $query);
            $sku_id = $this->db->insert_id();
            // product_skus_items
            $skus_items = [];
            foreach ($sku['values'] as $value){
                $skus_items[] = array(
                    'sku_id' => $sku_id,
                    'item_id' => $value['item_id'],
                    'attribute_id' => $value['attribute_id']
                );
            }
            $this->db->insert_batch('product_skus_items', $skus_items);
        }

        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            return FALSE;
        }

        return TRUE;
    }
}