<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'UserModel');
    }

    public function index_get()
    {
        $user = Authorization::getUserFromToken();
        $this->set_response($user, REST_Controller::HTTP_OK);
    }
}


