<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = array(
    'class'    => 'SystemHook',
    'function' => 'index',
    'filename' => 'SystemHook.php',
    'filepath' => 'hooks',
    'params'   => []
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'BackendApiHook',
    'function' => 'index',
    'filename' => 'BackendApiHook.php',
    'filepath' => 'hooks',
    'params'   => []
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'BackendPermissionHook',
    'function' => 'index',
    'filename' => 'BackendPermissionHook.php',
    'filepath' => 'hooks',
    'params'   => []
);



