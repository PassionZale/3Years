<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Product extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'Product');
    }

    public function list_get()
    {
        $page = $this->get('page');
        $products = $this->Product->get($page);
        echoSuccess($products);
    }

}