<?php

class User extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('user_service');
    }

    /**
     * userList 用户管理——用户列表
     * @author gethin <gethin.yan@gmail.com>
     */
    public function userList()
    {
        $arrInput = $this->getGetData();
        $arrOutput = $this->user_service->userList($arrInput);
        if (false === $arrOutput) {
            log_message('error', 'user call user_service userList fail. input:['.serialize($arrInput).'], output:['.serialize($arrOutput).']');

            return $this->returnJson(Statuscode::FAIL);
        }

        return $this->returnJson(Statuscode::SUCCESS, $arrOutput);
    }

    /**
     * userAdd 用户管理——添加用户
     * @author gethin <gethin.yan@gmail.com>
     */
    public function userAdd()
    {
        $arrInput = $this->getPostData();
        $arrOutput = $this->user_service->userAdd($arrInput);
        if (false === $arrOutput) {
            log_message('error', 'user call user_service userAdd fail. input:['.serialize($arrInput).'], output:['.serialize($arrOutput).']');

            return $this->returnJson(Statuscode::FAIL);
        }

        return $this->returnJson(Statuscode::SUCCESS, $arrOutput);
    }

    /**
     * updateStatus 用户管理——更新状态
     * @author gethin <gethin.yan@gmail.com>
     */
    public function updateStatus()
    {
        $arrInput = $this->getPostData();
        $arrOutput = $this->user_service->updateStatus($arrInput);
        if (false === $arrOutput) {
            log_message('error', 'user call user_service updateStatus fail. input:['.serialize($arrInput).'], output:['.serialize($arrOutput).']');

            return $this->returnJson(Statuscode::FAIL);
        }

        return $this->returnJson(Statuscode::SUCCESS, $arrOutput);
    }
}
