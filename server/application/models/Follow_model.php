<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function all(){
        // TODO 分页 & 筛选
        $query = $this->db->get('wechat_follow');
        return $query->result_array();
    }

    public function subscribe($follow)
    {
        $data = array(
            'openid' => $follow['openid'],
            'headimgurl' => $follow['headimgurl'],
            'nickname' => deal_emoji($follow['nickname'], 0),
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
