<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Category extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Category_model', 'Category');
    }

    public function index_get() {
        echoSuccess();
    }

}
