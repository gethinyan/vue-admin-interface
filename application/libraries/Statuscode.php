<?php

class Statuscode
{
    const SUCCESS = 1;
    const FAIL = -1;
    const PARAM_ERROR = -10001;
	const UNAME_PWD_ERROR = -100002;
    const USER_NOT_LOGIN = -10003;

    private static $messageMap = [
        1 => '操作成功',
        -1 => '操作失败',
        -10001 => '参数错误',
        -100002 => '用户名密码错误',
        -100003 => '用户未登录',
    ];

    public static function getMessage($statuscode)
    {
        if (isset(self::$messageMap[$statuscode])) {
            return self::$messageMap[$statuscode];
        }

        return '未知错误';
    }
}
