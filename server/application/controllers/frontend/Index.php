<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
    }

    public function run()
    {
        $this->ci_wechat->valid();
    }

}