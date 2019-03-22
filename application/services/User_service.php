<?php

class User_service extends Base_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function userList($arrInput)
    {
        $pageNo = empty($arrInput['pageNo']) ? Constant::DEFAULT_PAGE_NO : $arrInput['pageNo'];
        $pageSize = empty($arrInput['pageSize']) ? Constant::DEFAULT_PAGE_SIZE : $arrInput['pageSize'];
        $userList = $this->user_model->userList([], $pageSize, ($pageNo - 1) * $pageSize);
        $returnData = [
            'list' => $userList,
            'pageTotal' => $this->user_model->count,
        ];

        return $returnData;
    }

    public function userAdd($arrInput)
    {
        // params verify
        return $this->user_model->insert($arrInput);
    }

    public function updateStatus($arrInput)
    {
        // params verify
        if (empty($arrInput['userIds']) || empty($arrInput['status'])) {
            log_message('error', 'user_service updateStatus params error. input:['.serialize($arrInput).']');
            $this->statuscode = Statuscode::PARAM_ERROR;

            return false;
        }
        $where = 'user_id IN ('.implode(',', $arrInput['userIds']).')';
        $updateData = [
            'status' => $arrInput['status'],
        ];

        return $this->user_model->update($where, $updateData);
    }
}
