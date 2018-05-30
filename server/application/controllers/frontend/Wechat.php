<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
    }

    // http://server.3years.lovchun.com/frontend/wechat/run
    public function run()
    {
        $this->ci_wechat->valid();
    }

}