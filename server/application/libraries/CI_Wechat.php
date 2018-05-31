<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'third_party/wechat-sdk/wechat.class.php');

class CI_Wechat extends Wechat
{
    protected $_CI;

    public function __construct()
    {
        $this->_CI =& get_instance();
        $this->_CI->config->load('wechat');
        $options = $this->_CI->config->item('wechat');
        $this->_CI->load->driver('cache');
        parent::__construct($options);
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired)
    {
        return $this->_CI->cache->save($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        return $this->_CI->cache->get($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename)
    {
        return $this->_CI->cache->delete($cachename);
    }
}



