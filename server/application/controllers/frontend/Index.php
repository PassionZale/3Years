<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
        $this->load->model('Follow_model', 'Follow');
    }

    public function run()
    {
        $this->ci_wechat->valid();
        $type = $this->ci_wechat->getRev()->getRevType();
        $openid = $this->ci_wechat->getRevFrom();
        switch ($type) {
            case 'text':
                $this->ci_wechat->text('It\'s Beta Version...')->reply();
                break;
            case 'event':
                $info = $this->ci_wechat->getRevEvent();
                if (isset($info['event'])) {
                    switch ($info['event']) {
                        case 'subscribe':
                            $follow = $this->ci_wechat->getUserinfo($openid);
                            $this->ci_wechat->text('Welcome to subscribe 3Years.')->reply();
                            $this->Follow->subscribe($follow);
                            break;
                        case 'unsubscribe':
                            $this->Follow->un_subscribe($openid);
                            break;
                        default:
                            break;
                    }
                }
                break;
            default:
                $this->ci_wechat->text('default')->reply();
        }
    }

    public function init_follows()
    {
        $openids = $this->ci_wechat->getUserList();
        foreach ($openids['data']['openid'] as $openid) {
            $follow = $this->ci_wechat->getUserInfo($openid);
            $this->Follow->subscribe($follow);
        }
    }

    public function deploy_menus()
    {
        $data = array(
            'button' => array(
                array(
                    'name' => '商城首页',
                    'type' => 'view',
                    'url' => 'https://www.lovchun.com'
                ),
            )
        );
        $result = $this->ci_wechat->createMenu($data);
        var_dump($result);
    }

}
