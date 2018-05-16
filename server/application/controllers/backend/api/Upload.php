<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Upload extends REST_Controller
{

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
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            $arr_image = array('upload_data' => $this->upload->data());
            $file_path = '/uploads/product/thumbs/' . $dir_name . '/' .$arr_image['file_name'];
            echoMsg(0, $file_path);
        }
    }

    public function product_banners_post()
    {

    }
}