<?php

class SystemHook
{

    /**
     * 校验 superuser.lock 文件是否存在
     */
    public function index()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        if (!file_exists(APPPATH . 'superuser.lock') && $request_uri !== '/backend/auth/superuser') {
            header('Content-Type: text/plain; charset=utf-8');
            set_status_header(406, 'superuser is not exist');
            exit(json_encode(array(
                'ret_code' => 'superuser is not exist',
                'ret_msg' => '未创建超级管理员！'
            )));
        }
    }

}







