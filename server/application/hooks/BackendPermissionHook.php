<?php

class BackendPermissionHook
{
    private $CI;
    private $route;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->route = '/^backend\/api/i';
        $this->CI->load->model('Permission_model', 'Permission');
        $this->CI->load->model('User_model', 'User');
    }

    public function index()
    {
        if (preg_match($this->route, uri_string())) {
            $user_id = Authorization::getUserIdFromToken();
            // 若没有 superuser 标识
            if (!$this->CI->Permission->is_superuser($user_id)) {
                // 若账户处于启用状态
                if($this->CI->User->is_active($user_id)){
                    $resource = $this->CI->uri->segment(3, FALSE);
                    // 若当前 resource 在权限表中存在,即需要对其进行验证
                    if ($this->CI->Permission->resource_exist($resource)) {
                        // 若当前用户不拥有权限,则 403
                        if (!$this->CI->Permission->has_permission($user_id, $resource)) {
                            header('Content-Type: text/plain; charset=utf-8');
                            set_status_header(403);
                            $response = array(
                                'ret_code' => 'fail',
                                'ret_msg' => '没有权限'
                            );
                            exit(json_encode($response));
                        }
                    }
                }else{
                    header('Content-Type: text/plain; charset=utf-8');
                    set_status_header(403);
                    $response = array(
                        'ret_code' => 'account disabled',
                        'ret_msg' => '账户被冻结，请联系管理员'
                    );
                    exit(json_encode($response));
                }
            }
        }
    }

}