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

        switch ($type){
            case 'text':
                $this->ci_wechat->text('It\'s Beta Version...')->reply();
                break;
            case 'event':
                $info = $this->ci_wechat->getRevEvent();
                if (isset($info['event'])) {
                    switch ($info['event']) {
                        case 'subscribe':
                            $follow = $this->ci_wechat->getUserinfo($openid);
                            $this->FollowModel->subscribe($follow);
                            $this->ci_wechat->text('Welcome to subscribe 3Years.')->reply();
                            break;
                        case 'unsubscribe':
                            $this->FollowModel->un_subscribe($openid);
                            break;
                        default:
                            break;
                    }
                }
                break;
        }
    }

}