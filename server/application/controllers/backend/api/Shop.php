<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Shop extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Freight_model', 'Freight');
    }

    public function freight_get()
    {
        $freight = $this->Freight->show();
        echoSuccess($freight);
    }

    public function freight_put()
    {
        $data = $this->put();
        $result = $this->Freight->update($data);
        $result ? echoSuccess() : echoFail();
    }

}