<?php

class User_service extends Base_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        return $this->user_model->index();
    }
}
