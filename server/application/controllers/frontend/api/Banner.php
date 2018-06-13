<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Banner extends REST_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model', 'Banner');
    }

    public function index_get(){
        $banners = $this->Banner->get();
        echoSuccess($banners);
    }

}