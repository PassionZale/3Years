<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{

    private $page_size = 10;

    function __construct()
    {
        parent::__construct();
    }

    public function get($page){
        $page_size = 5;
        $query = $this->db->select('id, name, thumb_img, original_price,current_price,sort')
            ->where('status', 1)
            ->order_by('sort desc')
            ->limit($this->page_size, ($page - 1) * $this->page_size)
            ->get('product_products');
        return $query->result_array();
    }

    public function total($category, $keyword)
    {
        $this->db->select('id');
        if ($category !== 'all') {
            $this->db->where('category_id', $category);
        }

        if ($keyword) {
            $this->db->like('name', $keyword, 'both');
        }
        $total = $this->db->from('product_products')->count_all_results();
        return $total;
    }

    public function all($page, $category, $keyword)
    {
        $response = array(
            'paginate' => [],
            'data' => [],
        );

        $this->db->select('
                p.id,
                p.category_id,
                c.name as category_name,
                p.name,
                p.thumb_img, 
                p.original_price, 
                p.current_price, 
                p.sold,
                p.stock,
                p.status, 
                p.created_at,
                p.updated_at
            ')
            ->from('product_products as p');

        if ($category !== 'all') {
            $this->db->where('p.category_id', $category);
        }

        if ($keyword) {
            $this->db->like('p.name', $keyword, 'both');
        }

        $this->db->join('product_categories as c', 'c.id = p.category_id');
        $this->db->order_by('p.id desc');
        $this->db->limit($this->page_size, ($page - 1) * $this->page_size);
        $query = $this->db->get();

        $response['data'] = $query->result_array();

        $response['paginate'] = array(
            'page' => $page,
            'total' => $this->total($category, $keyword)
        );

        return $response;
    }

    public function show($id)
    {
        // product_proudcts
        $query = $this->db->select('
                id, sort, category_id, name,
                original_price,current_price,
                sold, stock, status, thumb_img,
                base_info, detail_info
            ')->where('id', $id)
            ->from('product_products')
            ->get();
        $info = $query->row_array();

        $query = $this->db->select('p_id')->where('id', $info['category_id'])->from('product_categories')->get();
        $result = $query->row_array();
        $category = [$result['p_id'], $info['category_id']];
        $thumb_img = array('url' => $info['thumb_img']);

        $product = array(
            'id' => (int)$info['id'],
            'sort' => (int)$info['sort'],
            'category' => $category,
            'name' => $info['name'],
            'original_price' => (float)$info['original_price'],
            'current_price' => (float)$info['current_price'],
            'sold' => (int)$info['sold'],
            'stock' => (int)$info['stock'],
            'status' => (int)$info['status'],
            'thumb_img' => $thumb_img,
            'base_info' => $info['base_info'],
            'detail_info' => $info['detail_info'],
        );

        // product_banners
        $query = $this->db->select('imgurl as url')->where('product_id', $id)->from('product_products_banners')->get();
        $product['banners'] = $query->result_array();

        // product_skus
        $query = $this->db->select('id, price, stock')
            ->where('product_id', $id)
            ->from('product_skus')
            ->get();
        $result = $query->result_array();
        $skus = [];
        foreach ($result as $sku) {
            $variant = array(
                'sku_id' => $sku['id'],
                'sku_price' => (float)$sku['price'],
                'sku_stock' => (int)$sku['stock'],
            );
            $query = $this->db->select('item_id, attribute_id')->where('sku_id', $sku['id'])->from('product_skus_items')->get();
            $values = $query->result_array();
            $variant['values'] = $values;
            $skus[] = $variant;
        }
        $product['skus'] = $skus;

        return $product;
    }

    public function create($data)
    {

        $this->db->trans_start();

        $missing_thumb = '//' . $_SERVER['HTTP_HOST'] . '/assets/images/missing_thumb.png';
        $thumb_img = isset($data['thumb_img']) ? $data['thumb_img']['url'] : $missing_thumb;

        // product_products
        $product = array(
            'category_id' => $data['category'][1],
            'name' => $data['name'],
            'thumb_img' => $thumb_img,
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
        $banners_arr = isset($data['banners']) ? $data['banners'] : [];
        $banners = [];
        if ($banners_arr) {
            foreach ($banners_arr as $banner) {
                $banners[] = array(
                    'product_id' => $product_id,
                    'imgurl' => $banner['url']
                );
            }
            $this->db->insert_batch('product_products_banners', $banners);
        }

        // product_skus
        $skus_arr = isset($data['skus']) ? $data['skus'] : [];
        if ($skus_arr) {
            foreach ($skus_arr as $sku) {
                $query = array(
                    'product_id' => $product_id,
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
        }


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('product_products', ['status' => 0]);
        return $result;
    }

    public function update_info($id, $data)
    {
        $data['category_id'] = $data['category'][1];
        unset($data['category']);
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('product_products', $data);
    }

    public function update_image($id, $data)
    {
        $thumb = array('thumb_img' => $data['thumb_img']['url']);
        $banners = [];
        foreach ($data['banners'] as $banner) {
            $banners[] = array(
                'product_id' => $id,
                'imgurl' => $banner['url']
            );
        }
        $this->db->trans_start();

        $this->db->where('id', $id)->update('product_products', $thumb);
        $this->db->where('product_id', $id)->delete('product_products_banners');
        $this->db->insert_batch('product_products_banners', $banners);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    public function update_detail($id, $data)
    {
        return $this->db->where('id', $id)->update('product_products', $data);
    }

}