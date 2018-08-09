<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Upload extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }

    private function generate_folder($folder_path)
    {
        if (!is_readable($folder_path)) {
            mkdir($folder_path, 0700, TRUE);
        }
        return $folder_path;
    }

    public function category_post()
    {
        $dir_name = date('Y-m-d');
        $upload_path = $this->generate_folder('./uploads/category/' . $dir_name . '/');
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpeg|jpg|png',
            'max_size' => 1024,
            'encrypt_name' => TRUE,
        );
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('category_img')) {
            $errors = $this->upload->display_errors();
            echoFail(strip_tags($errors));
        } else {
            $arr_image = $this->upload->data();
            $file_name = $arr_image['orig_name'];
            $file_path = '//' . $_SERVER['HTTP_HOST'] . '/uploads/category/' . $dir_name . '/' . $arr_image['file_name'];
            $result = array(
                'name' => $file_name,
                'url' => $file_path
            );
            echoSuccess($result);
        }
    }

    public function product_thumb_img_post()
    {
        $dir_name = date('Y-m-d');
        $upload_path = $this->generate_folder('./uploads/product/thumbs/' . $dir_name . '/');
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpeg|jpg|png',
            'max_size' => 1024,
            'encrypt_name' => TRUE,
        );
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('thumb_img')) {
            $errors = $this->upload->display_errors();
            echoFail(strip_tags($errors));
        } else {
            $arr_image = $this->upload->data();
            $file_name = $arr_image['orig_name'];
            $file_path = '//' . $_SERVER['HTTP_HOST'] . '/uploads/product/thumbs/' . $dir_name . '/' . $arr_image['file_name'];
            $result = array(
                'name' => $file_name,
                'url' => $file_path
            );
            echoSuccess($result);
        }
    }

    public function product_banners_post()
    {
        $dir_name = date('Y-m-d');
        $upload_path = $this->generate_folder('./uploads/product/banners/' . $dir_name . '/');
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpeg|jpg|png',
            'max_size' => 2048,
            'encrypt_name' => TRUE,
        );
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('banner')) {
            $errors = $this->upload->display_errors();
            echoFail(strip_tags($errors));
        } else {
            $arr_image = $this->upload->data();
            $file_name = $arr_image['orig_name'];
            $file_path = '//' . $_SERVER['HTTP_HOST'] . '/uploads/product/banners/' . $dir_name . '/' . $arr_image['file_name'];
            $result = array(
                'name' => $file_name,
                'url' => $file_path
            );
            echoSuccess($result);
        }
    }

    public function product_editor_images_post()
    {
        $dir_name = date('Y-m-d');
        $upload_path = $this->generate_folder('./uploads/product/editors/' . $dir_name . '/');
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpeg|jpg|png',
            'max_size' => 2048,
            'encrypt_name' => TRUE,
        );

        $file_info = array();

        $files = $_FILES;
        $loop = count($files['editor_images']['name']);

        for ($i = 0; $i < $loop; $i++) {
            $_FILES['editor_images']['name'] = $files['editor_images']['name'][$i];
            $_FILES['editor_images']['type'] = $files['editor_images']['type'][$i];
            $_FILES['editor_images']['tmp_name'] = $files['editor_images']['tmp_name'][$i];
            $_FILES['editor_images']['error'] = $files['editor_images']['error'][$i];
            $_FILES['editor_images']['size'] = $files['editor_images']['size'][$i];
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('editor_images')) {
                $errors = $this->upload->display_errors();
                exit(echoJson(['errno' => 1, 'msg' => strip_tags($errors)]));
            } else {
                $arr_image = $this->upload->data();
                $file_path = '//' . $_SERVER['HTTP_HOST'] . '/uploads/product/editors/' . $dir_name . '/' . $arr_image['file_name'];
                $file_info[] = $file_path;
            }
        }

        echoJson(array(
            'errno' => 0,
            'data' => $file_info
        ));
    }

    public function shop_banner_post()
    {
        $dir_name = date('Y-m-d');
        $upload_path = $this->generate_folder('./uploads/shop/banners/' . $dir_name . '/');
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpeg|jpg|png',
            'max_size' => 2048,
            'encrypt_name' => TRUE,
        );
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('banner')) {
            $errors = $this->upload->display_errors();
            echoFail(strip_tags($errors));
        } else {
            $arr_image = $this->upload->data();
            $file_name = $arr_image['orig_name'];
            $file_path = '//' . $_SERVER['HTTP_HOST'] . '/uploads/shop/banners/' . $dir_name . '/' . $arr_image['file_name'];
            $result = array(
                'name' => $file_name,
                'url' => $file_path
            );
            echoSuccess($result);
        }
    }

}
