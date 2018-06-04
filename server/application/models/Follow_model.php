<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Emoji');
    }

    public function all(){
        // TODO 分页 & 筛选
        $query = $this->db->get('wechat_follow');
        $follows = [];
        foreach($query->result_array() as $follow){
            $follow['nickname'] = $this->ci_emoji->de($follow['nickname']);
            $follows[] = $follow;
        }
        return $follows;
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
