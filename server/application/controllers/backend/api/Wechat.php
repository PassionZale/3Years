<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Wechat extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Follow_model', 'Follow');
    }

    public function follow_get()
    {
        $result = $this->Follow->all();
        echoSuccess($result);
    }
}