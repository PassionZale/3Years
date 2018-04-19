<?php

class ErrCode
{
    public static $errCode = array(
        '40001' => '超级管理员已存在',
    );

    public static function getErrText($err)
    {
        if (isset(self::$errCode[$err])) {
            return self::$errCode[$err];
        } else {
            return FALSE;
        }
    }
}