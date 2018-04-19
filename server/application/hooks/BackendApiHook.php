<?php

class BackendApiHook {

    // CI instance
    private $CI;
    // 需要加入钩子函数保护的路由
    private $route;

    public function __construct() {
        $this->CI = &get_instance();
        $this->route = '/^backend\/api/i';
    }

    /**
     * 拦截 backend/api/ 下的全部请求
     * 判断是否含有 Authorization Token
     */
    public function index() {
        $this->CI->load->helper('url');
        // $route 正则匹配是否符合 backend/api/*
        if (preg_match($this->route, uri_string())) {
            // 获取整个 request headers
            $headers = $this->CI->input->request_headers();
            // headers 中是否存在 Authorization
            if ($this->tokenIsExist($headers)) {
                // Authorization 中是否存在 json web token
                $jwt = $this->jwtIsExist($headers);
                // 校验 json web token
                $this->validateToken($jwt);
            } else {
                $this->httpUnauthorizedResponse(
                    'The request lacks the authorization token'
                );
            }
        }
    }

    /**
     * 判断 headers 中是否含有 Authorization 字段
     * 
     * @param type $headers
     * @return type boolean
     */
    public function tokenIsExist($headers = array()) {
        return (
                array_key_exists('Authorization', $headers) &&
                !empty($headers['Authorization'])
                );
    }

    /**
     * Authorization 中是否有 json web token 值
     * 
     * @param type $headers
     * @return type
     */
    public function jwtIsExist($headers) {
        list($jwt) = sscanf($headers['Authorization'], 'lovchun.com %s');
        return $jwt;
    }

    /**
     * 校验 json web token 的合法性
     * 
     * @param type $jwt
     * @return boolean
     */
    public function validateToken($jwt) {
        if ($jwt) {
            try {
                $token = Authorization::validateToken($jwt);
                return $token;
            } catch (Exception $ex) {
                $this->httpUnauthorizedResponse($ex->getMessage());
            }
        } else {
            $this->httpUnauthorizedResponse(
                    'the token is unauthorized'
            );
        }
    }

    /**
     * http code 401 response
     * 
     * @param type $msg
     */
    public function httpUnauthorizedResponse($msg = NULL) {
        header('Content-Type: text/plain; charset=utf-8');
        set_status_header(401, $msg);
        exit('未经授权');
    }

}