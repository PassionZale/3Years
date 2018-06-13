<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $query = $this->db->select('sort, imgurl, redirect')
            ->order_by('sort desc')
            ->get('shop_banner');
        return $query->result_array();
    }

    public function show($id)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('shop_banner');

        if ($id) {
            $result = $query->row_array();
            $result['sort'] = (int)$result['sort'];
            return array(
                'sort' => (int)$result['sort'],
                'imgurl' => $result['imgurl'],
                'redirect' => $result['redirect'],
            );
        } else {
            return $query->result_array();
        }
    }

    public function update($id, $data)
    {
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('shop_banner', $data);
    }

    public function create($data)
    {
        $banner = array(
            'sort' => $data['sort'],
            'imgurl' => $data['imgurl'],
            'redirect' => $data['redirect'],
            'created_at' => current_date(),
            'updated_at' => current_date(),
        );
        return $this->db->insert('shop_banner', $banner);
    }

    public function delete($id)
    {
        return $this->db->delete('shop_banner', ['id' => $id]);
    }
}