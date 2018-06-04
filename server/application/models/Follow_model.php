<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow_model extends CI_Model
{
    private $page_size = 10;

    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Emoji');
    }

    public function total(){
        $this->db->select('id');
        $total = $this->db->from('wechat_follow')->count_all_results();
        return $total;
    }

    public function all($filter = array())
    {

        $response = array(
            'paginate' => [],
            'data' => [],
        );

        $this->db->select('id, openid, headimgurl, nickname, sex, country, province, city, subscribe, subscribe_time');
        $this->db->from('wechat_follow');

        if($filter){
            $page = $filter['page'];
        }else{
            $page = 1;
        }
        $this->db->limit($this->page_size, ($page - 1) * $this->page_size);
        $query = $this->db->get();

        $follows = [];
        foreach ($query->result_array() as $follow) {
            $follow['nickname'] = $this->ci_emoji->de($follow['nickname']);
            $follows[] = $follow;
        }

        $response['data'] = $follows;
        $response['paginate'] = array(
            'page' => $page,
            'total' => $this->total()
        );

        return $response;
    }

    public function subscribe($follow)
    {
        $data = array(
            'openid' => $follow['openid'],
            'headimgurl' => $follow['headimgurl'],
            'nickname' => $this->ci_emoji->en($follow['nickname']),
            'sex' => $follow['sex'],
            'city' => $follow['city'],
            'province' => $follow['province'],
            'country' => $follow['country'],
            'subscribe' => $follow['subscribe'],
            'subscribe_time' => date('Y-m-d H:i:s', $follow['subscribe_time']),
            'subscribe_scene' => $follow['subscribe_scene'],
            'qr_scene' => $follow['qr_scene'],
            'qr_scene_str' => $follow['qr_scene_str'],
        );
        $this->db->where('openid', $follow['openid']);
        $query = $this->db->get('wechat_follow');
        $this->db->reset_query();
        if ($query->num_rows() > 0) {
            $updates = $data;
            unset($updates['openid']);
            $this->db->where('openid', $follow['openid'])->update('wechat_follow', $updates);
        } else {
            $this->db->insert('wechat_follow', $data);
        }
    }

    public function un_subscribe($openid)
    {
        $this->db->where('openid', $openid);
        $this->db->update('wechat_follow', ['subscribe' => 0]);
    }
}
