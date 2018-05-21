<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Product extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation', 'form');
        $this->load->model('Category_model', 'Category');
        $this->load->model('Attribute_model', 'Attribute');
        $this->load->model('Product_model', 'Product');
    }

    public function index_get($id)
    {
    }

    public function index_post()
    {
        $data = $this->input->post();
        $result = $this->Product->create($data);
        $result ? echoSuccess() : echoFail();
    }

    public function index_put($id)
    {

    }

    public function index_delete($id)
    {

    }

    public function childCategories_get($id)
    {
        if (empty($id)) {
            $this->set_response(array(
                'ret_code' => 'fail',
                'ret_msg' => '无效的参数'
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $categories = $this->Category->child_categories($id);
            $p_categories = $this->Category->show($id);
            // 将父分类插入数组的开头
            array_unshift($categories, $p_categories);
            $this->set_response(array(
                'ret_code' => 0,
                'ret_msg' => $categories
            ), REST_Controller::HTTP_OK);
        }
    }

    public function parentCategories_get()
    {
        $categories = $this->Category->parent_categories();
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => $categories
        ), REST_Controller::HTTP_OK);
    }

    public function categories_get()
    {
        $categories = $this->Category->all();
        echoMsg(0, $categories);
    }

    public function category_post()
    {
        if ($this->form_validation->run('category') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $data = $this->input->post();
            $result = $this->Category->create($data);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function category_delete($id)
    {
        $result = $this->Category->delete($id);
        $result ? echoSuccess() : echoFail();
    }

    public function category_put($id)
    {
        $data = $this->put();
        $this->form_validation->set_data($data);
        if ($this->form_validation->run('category') === FALSE) {
            $errors = $this->form_validation->error_array();
            echoFail(current($errors));
        } else {
            $result = $this->Category->update($id, $data);
            $result ? echoSuccess() : echoFail();
        }
    }

    public function category_get($id)
    {
        $category = $this->Category->show($id);
        $this->set_response(array(
            'ret_code' => 0,
            'ret_msg' => $category
        ), REST_Controller::HTTP_OK);
    }

    public function attribute_post()
    {
        $data = $this->input->post();
        $result = $this->Attribute->create($data);
        $result ? echoSuccess() : echoFail();
    }

    public function attributes_get()
    {
        $category_id = $this->get('category_id');
        $page = $this->get('page');
        $category_id === null && $category_id = 'all';
        if ($page !== 'all' && $page === null) {
            $page = 1;
        }
        $attributes = $this->Attribute->all($category_id, $page);
        echoMsg(0, $attributes);
    }

    public function attribute_delete($id)
    {
        $result = $this->Attribute->delete($id);
        $result ? echoSuccess() : echoFail();
    }

    public function attribute_put($id)
    {
        $data = $this->put();
        $result = $this->Attribute->update($id, $data);
        $result ? echoSuccess() : echoFail();
    }

    public function attribute_get($id)
    {
        $attribute = $this->Attribute->show($id);
        echoMsg(0, $attribute);
    }

}