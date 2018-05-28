<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Shop extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation', 'form');
        $this->load->model('Freight_model', 'Freight');
        $this->load->model('Banner_model', 'Banner');
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

    public function banner_get($id = FALSE)
    {
        $banners = $this->Banner->show($id);
        echoSuccess($banners);
    }

    public function banner_post()
    {
        if ($this->form_validation->run('banner') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $data = $this->input->post();
            $result = $this->Banner->create($data);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function banner_put($id)
    {
        $data = $this->put();
        $this->form_validation->set_data($data);
        if($this->form_validation->run('banner') === FALSE){
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        }else{
            $result = $this->Banner->update($id, $data);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function banner_delete($id)
    {
        $result = $this->Banner->delete($id);
        $result ? echoSuccess() : echoFail();
    }

}