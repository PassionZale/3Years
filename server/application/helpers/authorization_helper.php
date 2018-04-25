<?php

require_once APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

class Authorization
{

    /**
     * 校验 Authorization Token 合法性
     *
     * @param $token
     * @return object
     */
    public static function validateToken($token)
    {
        $CI =& get_instance();
        $key = $CI->config->item('jwt_key');
        $algorithm = $CI->config->item('jwt_algorithm');
        return JWT::decode($token, $key, array($algorithm));
    }

    /**
     * 生成 Authorization Token
     *
     * @param $data
     * @return string
     */
    public static function generateToken($data)
    {
        $CI =& get_instance();
        $key = $CI->config->item('jwt_key');
        return JWT::encode($data, $key);
    }

    /**
     * 从 Authorization Token 中获取用户ID
     *
     * @return mixed
     */
    public static function getUserIdFromToken()
    {
        $CI =& get_instance();
        $headers = $CI->input->request_headers();
        list($jwt) = sscanf($headers['Authorization'], 'lovchun.com %s');
        $token = self::validateToken($jwt);
        $user_id = $token->id;
        return $user_id;
    }

}


